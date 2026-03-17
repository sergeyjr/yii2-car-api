app/
├── config/
│   ├── db.php
│   ├── di.php
│   ├── params.php
│   └── web.php
│
├── controllers/
│   └── api/
│       └── v1/
│           ├── AuthController.php
│           └── CarController.php
│
├── dto/
│   ├── request/
│   │   ├── CreateCarRequest.php
│   │   └── PaginationRequest.php
│   │
│   └── response/
│       ├── CarListResponse.php
│       └── CarResponse.php
│
├── entities/
│   ├── Car.php
│   ├── CarOption.php
│   └── User.php
│
├── mappers/
│   ├── CarDataMapper.php
│   └── UserDataMapper.php
│
├── migrations/
│   ├── m260313_212150_create_car_table.php
│   ├── m260313_212521_create_car_option_table.php
│   ├── m260315_185048_create_user_table.php
│   └── m260316_120834_seed_car_data.php
│
├── models/
│   └── activeRecord/
│       ├── CarAR.php
│       ├── CarOptionAR.php
│       └── UserAR.php
│
├── repositories/
│   ├── CarRepository.php
│   ├── CarRepositoryInterface.php
│   │
│   ├── CarOptionRepository.php
│   ├── CarOptionRepositoryInterface.php
│   │
│   ├── UserRepository.php
│   └── UserRepositoryInterface.php
│
├── services/
│   ├── AuthService.php
│   └── CarService.php
│
├── helpers/
│   └── ApiResponse.php
│
└── web/
├── index.php
├── api-test.html
└── js/
└── api-tester.js