Кто за что отвечает:

---

Controller (вход в систему)

- принимает HTTP-запрос
- валидирует (через DTO request)
- вызывает сервис
- возвращает ответ

ничего не знает про БД

---

DTO (request/response)

- request — проверяет входные данные
- response — форматирует ответ

просто контейнеры данных

---

Service (мозг системы)

здесь вся логика:

- создать объявление
- проверить пользователя
- связать данные

решает ЧТО делать, но не КАК хранить

---

Repository (работа с БД)

делает:

- сохранить
- найти
- получить список

- не содержит бизнес-логики
- просто “достать/сохранить”

---

DataMapper (переводчик)

- переводит:
ActiveRecord ⇄ Entity
Entity → DTO
- 
- из “грязных” моделей БД → в чистые объекты

---

Entity (бизнес-объекты)

- это “чистые” объекты:
без Yii
с логикой (например validatePassword())
-описывают суть данных

---

ActiveRecord (работа с таблицами)

- напрямую общаются с БД
- знают таблицы

используются только внутри repository/mapper

---

Database

- PostgreSQL
- хранит данные

---

Как всё работает (на примере)

Создание объявления (POST /car/create)

1. Controller
   получает запрос

2. CreateCarRequest
   валидирует данные

3. Service
   создает Car (Entity)

4. Repository
   сохраняет:
   Entity → Mapper → ActiveRecord → БД

5. Service
   возвращает Entity

6. Mapper
   превращает в DTO

7. Controller
   отдаёт JSON

---

Получение списка (GET /car/list)

1. Controller
   получает запрос

2. Service
   запрашивает список у Repository

3. Repository
   получает ActiveDataProvider (из БД)

4. Mapper
   делает:
   AR → Entity → DTO

5. Controller
   отдаёт список

---

Логин (Auth)

1. Controller

2. Service
   ищет пользователя

3. Repository
   достает UserAR → Mapper → User Entity

4. Entity
   validatePassword()

5. Service
   генерирует токен

6. Repository
   сохраняет токен

7. Controller
   возвращает токен
   Главное правило проекта
   Controller → Service → Repository → (Mapper) → DB

и обратно:

DB → Repository → Mapper → Entity → Service → Controller → DTO

---

В двух словах:

Controller — принимает
Service — думает
Repository — работает с БД
Mapper — переводит
Entity — хранит смысл
