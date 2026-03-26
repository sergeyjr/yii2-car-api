app/
├── config/
│   ├── di.php
│   ├── params.php
│   └── web.php
│
├── modules/
│   └── api/
│       ├── Module.php
│       │
│       └── v1/
│           ├── components/
│           │   └── auth/
│           │       └── FlexibleAuth.php
│           │
│           ├── controllers/
│           │   ├── BaseApiController.php
│           │   ├── AuthController.php
│           │   └── CarController.php
│           │
│           ├── dto/
│           │   ├── request/
│           │   │   ├── CarCreateRequest.php
│           │   │   ├── CarOptionRequest.php
│           │   │   └── PaginationRequest.php
│           │   │
│           │   └── response/
│           │       ├── CarListResponse.php
│           │       ├── CarOptionResponse.php
│           │       └── CarResponse.php
│           │
│           ├── entities/
│           │   ├── ApiUser.php
│           │   ├── Car.php
│           │   └── CarOption.php
│           │
│           ├── exceptions/
│           │   ├── RepositoryException.php
│           │   ├── UserNotFoundException.php
│           │   └── UserSaveException.php
│           │
│           ├── helpers/
│           │   └── ApiResponse.php
│           │
│           ├── mappers/
│           │   ├── ApiUserMapper.php
│           │   └── CarMapper.php
│           │
│           ├── models/
│           │   └── activeRecord/
│           │       ├── ApiUserAR.php
│           │       ├── CarAR.php
│           │       └── CarOptionAR.php
│           │
│           ├── repositories/
│           │   ├── ApiUserRepository.php
│           │   ├── CarOptionRepository.php
│           │   └── CarRepository.php
│           │
│           └── services/
│               ├── AuthService.php
│               └── CarService.php
│
├── migrations/
│   ├── m260313_212150_create_car_table.php
│   ├── m260313_212521_create_car_option_table.php
│   ├── m260315_185048_create_api_user_table.php
│   └── m260316_120834_seed_car_data.php