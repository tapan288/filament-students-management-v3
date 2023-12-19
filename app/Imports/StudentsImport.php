<?php

namespace App\Imports;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $class_id = self::getClassId($row['class']);

        return new Student([
            'name' => $row['name'],
            'email' => $row['email'],
            'class_id' => $class_id,
            'section_id' => self::getSectionId($row['section'], $class_id)
        ]);
    }

    public function getClassId(string $class)
    {
        return Classes::where('name', $class)->first()->id;
    }

    public static function getSectionId(string $section, int $class_id)
    {
        return Section::where('name', $section)
            ->where('class_id', $class_id)
            ->first()
            ->id;
    }
}
