<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            'school_name' => "Nsangi Parents' Primary School",
            'motto' => 'Education is the Key',
            'tagline' => "Nsangi Parents' Primary School is a mixed day and boarding school offering Nursery to P.6 education.",
            'school_story' => "Nsangi Parents' Primary School is a mixed day and boarding school located on Nsangi Masaka Road. We provide a supportive learning environment for children from Nursery to P.6, preparing them to become law abiding and productive citizens.",
            'phone' => '0772331480',
            'phone_2' => '0758 008545',
            'phone_3' => '',
            'email' => 'nsangiparentsschool@gmail.com',
            'address' => 'Nsangi Masaka Rd, P.O.Box 89',
            'levels_offered' => 'Nursery - P.6',
            'admission_status' => 'OPEN',
            'center_number' => '280020',
            'years_existence' => '',
            'head_teacher_name' => '',
            'head_teacher_message' => '',
            'mission' => 'To prepare law abiding and productive citizens for the country.',
            'mission_objectives' => "To encourage effective teaching/learning, so that pupils become productive in future.\nTo employ Sports teachers to emphasize co-curricular activities.\nTo put more practice in languages 1 x 2 for easy communication.\nTo sensitize Parents of the importance of education.\nTo develop the School in all possible ways to meet the minimum standard indicators.",
            'short_term_objectives' => "Teachers should teach willingly to eradicate laziness from pupils.\nTeachers and pupils should attend School daily and participate in the daily School activities.\nSchool administration to regularly monitor teaching/learning.",
            'vision' => '',
            'core_values' => '',
            'about_school_content' => "Nsangi Parents' Primary School is a mixed day and boarding school offering education from Nursery to P.6. Located on Nsangi Masaka Road, the school is committed to preparing law abiding and productive citizens for the country.",
            'school_anthem' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
};