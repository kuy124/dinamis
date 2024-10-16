<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataTable;
use App\Models\TableField;
use App\Models\TableRecord;
use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function index()
    {
        $tables = DataTable::with('fields')->get();
        return view('tables.index', compact('tables'));
    }

    public function user()
    {
        $tables = DataTable::with('fields')->get();
        return view('user.user', compact('tables'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function kontak()
    {
        return view('user.kontak');
    }


    public function destroy(DataTable $table)
    {
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Tabel dan semua rekaman berhasil dihapus');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.type' => 'required|in:text,number,date'
        ]);

        $table = DataTable::create([
            'table_name' => $request->table_name,
            'description' => $request->description
        ]);

        foreach ($request->fields as $field) {
            TableField::create([
                'data_table_id' => $table->id,
                'field_name' => $field['name'],
                'field_type' => $field['type']
            ]);
        }

        return redirect()->route('tables.index')->with('success', 'Tabel berhasil dibuat');
    }

    public function show(DataTable $table)
    {
        $months = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        $records = $table->records()->get();

        $records = $records->sortBy(function ($record) use ($months) {
            return $months[$record->month] ?? 0;
        });

        return view('tables.show', compact('table', 'records'));
    }

    public function showuser(DataTable $table)
    {
        $months = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        $records = $table->records()->get();

        $records = $records->sortBy(function ($record) use ($months) {
            return $months[$record->month] ?? 0; 
        });

        return view('user.show', compact('table', 'records'));
    }


    public function addRecord(Request $request, DataTable $table)
    {
        // Validasi bulan
        $validationRules = [
            'month' => 'required|string|in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember'
        ];

        // Dapatkan semua field untuk validasi
        foreach ($table->fields as $field) {
            $rule = 'required';
            switch ($field->field_type) {
                case 'number':
                    $rule .= '|numeric';
                    break;
                case 'date':
                    $rule .= '|date';
                    break;
                default:
                    $rule .= '|string|max:255';
            }
            $validationRules[$field->field_name] = $rule;
        }

        $validated = $request->validate($validationRules);

        TableRecord::create([
            'data_table_id' => $table->id,
            'month' => $validated['month'],
            'data' => collect($validated)->except('month')->toArray()
        ]);

        return redirect()->route('tables.show', $table)->with('success', 'Rekaman berhasil ditambahkan');
    }

    public function deleteRecord(TableRecord $record)
    {
        $table = $record->dataTable;
        $record->delete();
        return redirect()->route('tables.show', $table)->with('success', 'Rekaman berhasil dihapus');
    }

    // BARU: Memperbarui rekaman
    public function updateRecord(Request $request, TableRecord $record)
    {
        $table = $record->dataTable;

        // Validasi bulan
        $validationRules = [
            'month' => 'required|string|in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember'
        ];

        // Dapatkan semua field untuk validasi
        foreach ($table->fields as $field) {
            $rule = 'required';
            switch ($field->field_type) {
                case 'number':
                    $rule .= '|numeric';
                    break;
                case 'date':
                    $rule .= '|date';
                    break;
                default:
                    $rule .= '|string|max:255';
            }
            $validationRules[$field->field_name] = $rule;
        }

        $validated = $request->validate($validationRules);

        // Perbarui rekaman dengan field bulan
        $record->update([
            'month' => $validated['month'],
            'data' => collect($validated)->except('month')->toArray()
        ]);

        return redirect()->route('tables.show', $table)->with('success', 'Rekaman berhasil diperbarui');
    }

    public function charts()
    {
        $tables = DataTable::with(['fields', 'records'])->get();
        return view('charts', compact('tables'));
    }
}
