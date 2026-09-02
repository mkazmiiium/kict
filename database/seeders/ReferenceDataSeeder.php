<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use App\Models\Department;
use App\Models\DisabilityCategory;
use App\Models\Kulliyyah;
use App\Models\LetterType;
use App\Models\Offense;
use App\Models\Program;
use App\Models\ReadmissionCondition;
use App\Models\Signatory;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kulliyyah = Kulliyyah::firstOrCreate(
            ['name_en' => 'Kulliyyah of Information and Communication Technology (KICT)'],
            ['name_bm' => 'Kulliyyah Komunikasi dan Teknologi Maklumat']
        );

        $department = Department::firstOrCreate(
            [
                'kulliyyah_id' => $kulliyyah->id,
                'name_en' => 'Department of Information Technology',
            ],
            ['name_bm' => 'Jabatan Teknologi Maklumat']
        );

        $program = Program::firstOrCreate(
            ['code' => 'BIT'],
            [
                'department_id' => $department->id,
                'name_en' => 'Bachelor of Information Technology',
                'name_bm' => 'Ijazah Sarjana Muda Teknologi Maklumat',
            ]
        );

        $academicSessionsData = [
            ['semester' => 1, 'academic_year' => '2026/2027'],
            ['semester' => 2, 'academic_year' => '2026/2027'],
            ['semester' => 3, 'academic_year' => '2026/2027'],
            ['semester' => 1, 'academic_year' => '2025/2026'],
            ['semester' => 2, 'academic_year' => '2025/2026'],
            ['semester' => 3, 'academic_year' => '2025/2026'],
            ['semester' => 1, 'academic_year' => '2024/2025'],
            ['semester' => 2, 'academic_year' => '2024/2025'],
            ['semester' => 3, 'academic_year' => '2024/2025'],
            ['semester' => 1, 'academic_year' => '2023/2024'],
            ['semester' => 2, 'academic_year' => '2023/2024'],
            ['semester' => 3, 'academic_year' => '2023/2024'],
            ['semester' => 1, 'academic_year' => '2022/2023'],
            ['semester' => 2, 'academic_year' => '2022/2023'],
            ['semester' => 3, 'academic_year' => '2022/2023'],
            ['semester' => 1, 'academic_year' => '2021/2022'],
            ['semester' => 2, 'academic_year' => '2021/2022'],
            ['semester' => 3, 'academic_year' => '2021/2022'],
            ['semester' => 1, 'academic_year' => '2020/2021'],
            ['semester' => 2, 'academic_year' => '2020/2021'],
            ['semester' => 3, 'academic_year' => '2020/2021'],
            ['semester' => 1, 'academic_year' => '2019/2020'],
            ['semester' => 2, 'academic_year' => '2019/2020'],
            ['semester' => 3, 'academic_year' => '2019/2020'],
        ];

        foreach ($academicSessionsData as $sessionData) {
            AcademicSession::firstOrCreate($sessionData);
        }

        Signatory::firstOrCreate(
            ['name' => 'Asst. Prof. Dr. Mohd Khairul Azmi Hassan'],
            [
                'designation_en' => 'Deputy Dean (Student Development and Community Engagement)',
                'designation_bm' => 'Timbalan Dekan (Pembangunan Pelajar dan Penglibatan Komuniti)',
                'office' => 'DDSDCE',
                'signature_path' => 'assets/img/signature-mohd-khairul-azmi.png',
            ]
        );

        Student::firstOrCreate(
            ['matric_no' => '2327038'],
            [
                'name' => 'Ibnat Afiya',
                'gender' => 'female',
                'passport_no' => 'A00982009',
                'program_id' => $program->id,
                'department_id' => $department->id,
                'status' => 'active',
            ]
        );

        $bcsDepartment = Department::firstOrCreate(
            [
                'kulliyyah_id' => $kulliyyah->id,
                'name_en' => 'Department of Computer Science',
            ],
            ['name_bm' => 'Jabatan Sains Komputer']
        );

        $bcsProgram = Program::firstOrCreate(
            ['code' => 'BCS'],
            [
                'department_id' => $bcsDepartment->id,
                'name_en' => 'Bachelor of Computer Science',
                'name_bm' => 'Ijazah Sarjana Muda Sains Komputer',
            ]
        );

        $demoStudents = [
            ['name' => 'Ahmad Danial bin Zulkifli', 'gender' => 'male'],
            ['name' => 'Nur Aisyah binti Abdul Rahman', 'gender' => 'female'],
            ['name' => 'Muhammad Haris bin Ismail', 'gender' => 'male'],
            ['name' => 'Siti Nurhaliza binti Osman', 'gender' => 'female'],
            ['name' => 'Amirul Hakim bin Yusof', 'gender' => 'male'],
            ['name' => 'Fatimah Az-Zahra binti Kamal', 'gender' => 'female'],
            ['name' => 'Muhammad Aiman bin Sallehuddin', 'gender' => 'male'],
            ['name' => 'Nur Ain binti Mohd Faizal', 'gender' => 'female'],
            ['name' => 'Muhammad Irfan bin Hashim', 'gender' => 'male'],
        ];

        $matricStart = 2327039;

        foreach ($demoStudents as $index => $studentData) {
            $useBit = (bool) random_int(0, 1);

            Student::firstOrCreate(
                ['matric_no' => (string) ($matricStart + $index)],
                [
                    'name' => $studentData['name'],
                    'gender' => $studentData['gender'],
                    'program_id' => $useBit ? $program->id : $bcsProgram->id,
                    'department_id' => $useBit ? $department->id : $bcsDepartment->id,
                    'status' => 'active',
                ]
            );
        }

        LetterType::firstOrCreate(
            ['code' => 'ATTENDANCE', 'year' => (string) now()->year],
            [
                'name' => 'Attendance Letter',
                'reference_no_pattern' => 'IIUM/309/C/13/15/1/{running}',
                'current_running_number' => 0,
            ]
        );

        Student::firstOrCreate(
            ['matric_no' => '2217808'],
            [
                'name' => 'Rabiatul Adawiyah Binti Mohd Alwi',
                'gender' => 'female',
                'nric_no' => '030420-11-0554',
                'program_id' => $bcsProgram->id,
                'department_id' => $bcsDepartment->id,
                'year_of_study' => 4,
                'status' => 'active',
            ]
        );

        LetterType::firstOrCreate(
            ['code' => 'EXPECTED_GRADUATION', 'year' => (string) now()->year],
            [
                'name' => 'Expected Graduation Letter',
                'reference_no_pattern' => 'IIUM/309/12/1/{running}',
                'current_running_number' => 0,
            ]
        );

        LetterType::firstOrCreate(
            ['code' => 'LOA', 'year' => (string) now()->year],
            [
                'name' => 'Leave of Absence Letter',
                'reference_no_pattern' => 'IIUM/309/C/13/15/1/{running}',
                'current_running_number' => 0,
            ]
        );

        LetterType::firstOrCreate(
            ['code' => 'READMISSION', 'year' => (string) now()->year],
            [
                'name' => 'Readmission Letter',
                'reference_no_pattern' => 'IIUM/309/C/13/18/{running}',
                'current_running_number' => 0,
            ]
        );

        ReadmissionCondition::firstOrCreate(
            ['name' => 'Clean Slate'],
            [
                'footnote_text' => 'Clean Slate means that your previous academic record in IIUM is deleted and you start a fresh in the programme. Semester(s) deleted will be counted as part of the maximum period of study.',
            ]
        );

        ReadmissionCondition::firstOrCreate(
            ['name' => 'Good Academic Standing'],
            [
                'footnote_text' => 'Good Academic standing means that a student earns at least a CGPA of 2.00 in that semester. Therefore, record of courses taken in the semester(s) where the CGPA falls below 2.00 will be deleted and have to be taken again. Semester(s) deleted will be counted as part of the maximum period of study.',
            ]
        );

        $isDepartment = Department::firstOrCreate(
            [
                'kulliyyah_id' => $kulliyyah->id,
                'name_en' => 'Department of Information Systems',
            ],
            ['name_bm' => 'Jabatan Sistem Maklumat']
        );

        Student::firstOrCreate(
            ['matric_no' => '1833047'],
            [
                'name' => 'Hashimi Saud Ahmad',
                'gender' => 'male',
                'passport_no' => 'P06184293',
                'program_id' => $program->id,
                'department_id' => $isDepartment->id,
                'status' => 'active',
            ]
        );

        foreach ([
            'Dress Code Violation',
            'Long Hair',
            'Improper Attire',
            'Smoking in Prohibited Area',
            'Others',
        ] as $offenseName) {
            Offense::firstOrCreate(['name' => $offenseName]);
        }

        foreach ([
            'P' => 'Physical Disability',
            'H' => 'Hearing Impaired',
            'V' => 'Vision Impaired',
            'L' => 'Learning Disability',
            'S' => 'Speech Impaired',
        ] as $code => $name) {
            DisabilityCategory::firstOrCreate(['code' => $code], ['name' => $name]);
        }
    }
}
