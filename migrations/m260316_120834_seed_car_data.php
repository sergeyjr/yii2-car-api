<?php

use yii\db\Migration;

class m260316_120834_seed_car_data extends Migration
{

    public function safeUp()
    {

        $cars = [
            ['BMW X5', 'Comfortable SUV', 25000, 'https://example.com/bmw.jpg', 'admin@example.com'],
            ['Audi A4', 'German sedan', 18000, 'https://example.com/audi.jpg', 'admin@example.com'],
            ['Toyota Camry', 'Reliable sedan', 15000, 'https://example.com/camry.jpg', 'admin@example.com'],
            ['Honda Civic', 'Compact car', 12000, 'https://example.com/civic.jpg', 'admin@example.com'],
            ['Ford Focus', 'Economic hatchback', 9000, 'https://example.com/focus.jpg', 'admin@example.com'],
            ['Mercedes C200', 'Premium sedan', 22000, 'https://example.com/mercedes.jpg', 'admin@example.com'],
            ['Volkswagen Passat', 'Business sedan', 16000, 'https://example.com/passat.jpg', 'admin@example.com'],
            ['Skoda Octavia', 'Practical liftback', 14000, 'https://example.com/octavia.jpg', 'admin@example.com'],
            ['Kia Sportage', 'Modern SUV', 17000, 'https://example.com/sportage.jpg', 'admin@example.com'],
            ['Hyundai Tucson', 'Family SUV', 17500, 'https://example.com/tucson.jpg', 'admin@example.com'],
            ['Mazda 6', 'Sporty sedan', 15500, 'https://example.com/mazda6.jpg', 'admin@example.com'],
            ['Nissan Qashqai', 'Urban crossover', 16500, 'https://example.com/qashqai.jpg', 'admin@example.com'],
            ['Volvo XC60', 'Safety SUV', 26000, 'https://example.com/xc60.jpg', 'admin@example.com'],
            ['Subaru Forester', 'AWD crossover', 20000, 'https://example.com/forester.jpg', 'admin@example.com'],
            ['Peugeot 508', 'French sedan', 14500, 'https://example.com/508.jpg', 'admin@example.com'],
            ['Renault Megane', 'Compact hatchback', 11000, 'https://example.com/megane.jpg', 'admin@example.com'],
            ['Chevrolet Malibu', 'Comfort sedan', 13000, 'https://example.com/malibu.jpg', 'admin@example.com'],
            ['Tesla Model 3', 'Electric sedan', 35000, 'https://example.com/model3.jpg', 'admin@example.com'],
            ['Lexus RX', 'Luxury SUV', 30000, 'https://example.com/rx.jpg', 'admin@example.com'],
            ['Porsche Cayenne', 'Sport SUV', 45000, 'https://example.com/cayenne.jpg', 'admin@example.com'],
        ];

        foreach ($cars as $car) {
            $this->insert('car', [
                'title' => $car[0],
                'description' => $car[1],
                'price' => $car[2],
                'photo_url' => $car[3],
                'contacts' => $car[4],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $options = [
            ['BMW', 'X5', 2019, 'SUV', 80000],
            ['Audi', 'A4', 2018, 'Sedan', 90000],
            ['Toyota', 'Camry', 2020, 'Sedan', 60000],
            ['Honda', 'Civic', 2017, 'Sedan', 95000],
            ['Ford', 'Focus', 2016, 'Hatchback', 120000],
            ['Mercedes', 'C200', 2019, 'Sedan', 70000],
            ['Volkswagen', 'Passat', 2018, 'Sedan', 85000],
            ['Skoda', 'Octavia', 2019, 'Liftback', 75000],
            ['Kia', 'Sportage', 2021, 'SUV', 50000],
            ['Hyundai', 'Tucson', 2020, 'SUV', 52000],
            ['Mazda', '6', 2018, 'Sedan', 88000],
            ['Nissan', 'Qashqai', 2019, 'SUV', 64000],
            ['Volvo', 'XC60', 2021, 'SUV', 40000],
            ['Subaru', 'Forester', 2020, 'SUV', 45000],
            ['Peugeot', '508', 2018, 'Sedan', 91000],
            ['Renault', 'Megane', 2017, 'Hatchback', 100000],
            ['Chevrolet', 'Malibu', 2016, 'Sedan', 110000],
            ['Tesla', 'Model 3', 2022, 'Sedan', 20000],
            ['Lexus', 'RX', 2021, 'SUV', 35000],
            ['Porsche', 'Cayenne', 2020, 'SUV', 30000],
        ];

        $i = 1;
        foreach ($options as $opt) {
            $this->insert('car_option', [
                'car_id' => $i,
                'brand' => $opt[0],
                'model' => $opt[1],
                'year' => $opt[2],
                'body' => $opt[3],
                'mileage' => $opt[4],
            ]);
            $i++;
        }
    }

    public function safeDown()
    {
        $this->delete('car_option');
        $this->delete('car');
    }

}