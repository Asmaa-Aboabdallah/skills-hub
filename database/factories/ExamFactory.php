<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Exam::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $i = 0;
        $i++;
        return [
            'name' => json_encode([
                'en'=> $this->faker->word(), // create words dynamic    
                'ar'=> $this->faker->word(), // create words dynamic   
            ]),
            'desc' => json_encode([
                'en'=> $this->faker->text(5000), // create words dynamic    
                'ar'=> $this->faker->text(5000), // create words dynamic   
            ]),
            'img' => "exams/$i.png",
            'questions_no' => 15,
            'difficulty' => $this->faker->numberBetween(1,5),
            'duration_mins' => $this->faker->numberBetween(1,3) * 30,  // [30 , 60 , 90] 

        ];
    }
}
