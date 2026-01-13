# 🚀 MauMasakApa REST API Documentation

**Base URL:** `http://localhost:8000/api`

---

## 📋 Table of Contents

1. [Authentication](#authentication)
2. [Public Endpoints](#public-endpoints)
3. [Protected Endpoints](#protected-endpoints)
4. [Response Format](#response-format)
5. [Error Handling](#error-handling)
6. [Testing](#testing)

---

## 🔐 Authentication

### Token-Based Authentication (Sanctum)

Currently, the API uses **no authentication** for public endpoints. Protected endpoints require authentication.

**Future enhancement:** Add Laravel Sanctum for token-based auth:
```bash
php artisan install:api
```

**Usage with Token:**
```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 🌍 Public Endpoints

### 1. Get All Reseps
**Endpoint:** `GET /api/reseps`

**Query Parameters:**
- `page` (optional): Page number, default 1
- `per_page` (optional): Items per page, default 12

**Request:**
```bash
curl http://localhost:8000/api/reseps?page=1&per_page=12
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "judul": "Nasi Goreng",
            "bahan": "Nasi, Telur, Kecap",
            "langkah": "1. Panaskan minyak...",
            "gambar": "/storage/reseps/xxx.jpg",
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com"
            },
            "created_at": "2026-01-13T10:00:00Z",
            "updated_at": "2026-01-13T10:00:00Z"
        }
    ],
    "pagination": {
        "current_page": 1,
        "per_page": 12,
        "total": 50,
        "last_page": 5,
        "from": 1,
        "to": 12
    }
}
```

---

### 2. Get Single Resep Detail
**Endpoint:** `GET /api/reseps/{id}`

**Request:**
```bash
curl http://localhost:8000/api/reseps/1
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "judul": "Nasi Goreng",
        "bahan": "Nasi, Telur, Kecap",
        "langkah": "1. Panaskan minyak...",
        "gambar": "/storage/reseps/xxx.jpg",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "favorites_count": 5,
        "created_at": "2026-01-13T10:00:00Z",
        "updated_at": "2026-01-13T10:00:00Z"
    }
}
```

---

### 3. Get Reseps by User
**Endpoint:** `GET /api/reseps/{user_id}/user`

**Request:**
```bash
curl http://localhost:8000/api/reseps/1/user
```

**Response:**
```json
{
    "success": true,
    "count": 3,
    "data": [
        {
            "id": 1,
            "judul": "Nasi Goreng",
            "bahan": "...",
            "langkah": "...",
            "gambar": "/storage/reseps/xxx.jpg",
            "user": { ... }
        }
    ]
}
```

---

### 4. Search Reseps
**Endpoint:** `GET /api/search?q=nasi`

**Query Parameters:**
- `q` (required): Search query (minimum 2 characters)

**Request:**
```bash
curl http://localhost:8000/api/search?q=nasi+goreng
```

**Response:**
```json
{
    "success": true,
    "query": "nasi goreng",
    "count": 3,
    "data": [
        {
            "id": 1,
            "judul": "Nasi Goreng Spesial",
            "bahan": "...",
            "langkah": "...",
            "gambar": "/storage/reseps/xxx.jpg"
        }
    ]
}
```

---

## 🔒 Protected Endpoints

> ⚠️ **Note:** Protected endpoints currently don't require authentication. In production, implement Sanctum tokens.

### 5. Create New Resep
**Endpoint:** `POST /api/reseps`

**Headers:**
```
Content-Type: multipart/form-data
Authorization: Bearer YOUR_TOKEN (future)
```

**Request Parameters:**
- `judul` (required): Recipe title
- `bahan` (required): Ingredients
- `langkah` (required): Cooking steps
- `gambar` (optional): Image file

**Request (with curl):**
```bash
curl -X POST http://localhost:8000/api/reseps \
  -H "Content-Type: multipart/form-data" \
  -F "judul=Gado-Gado" \
  -F "bahan=Kacang, Sayur, Kecap" \
  -F "langkah=1. Rebus sayur..." \
  -F "gambar=@/path/to/image.jpg"
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Resep berhasil dibuat",
    "data": {
        "id": 2,
        "judul": "Gado-Gado",
        "bahan": "Kacang, Sayur, Kecap",
        "langkah": "1. Rebus sayur...",
        "gambar": "/storage/reseps/yyy.jpg",
        "user_id": 1,
        "created_at": "2026-01-13T11:00:00Z",
        "updated_at": "2026-01-13T11:00:00Z"
    }
}
```

---

### 6. Update Resep
**Endpoint:** `PUT /api/reseps/{id}`

**Request Parameters:**
- `judul` (optional): Updated title
- `bahan` (optional): Updated ingredients
- `langkah` (optional): Updated steps
- `gambar` (optional): New image

**Request (with curl):**
```bash
curl -X PUT http://localhost:8000/api/reseps/1 \
  -H "Content-Type: multipart/form-data" \
  -F "judul=Nasi Goreng Premium" \
  -F "bahan=Nasi, Telur Premium, Kecap"
```

**Response:**
```json
{
    "success": true,
    "message": "Resep berhasil diupdate",
    "data": { ... }
}
```

---

### 7. Delete Resep
**Endpoint:** `DELETE /api/reseps/{id}`

**Request:**
```bash
curl -X DELETE http://localhost:8000/api/reseps/1
```

**Response:**
```json
{
    "success": true,
    "message": "Resep berhasil dihapus"
}
```

---

### 8. Get User's Favorites
**Endpoint:** `GET /api/favorites`

**Request:**
```bash
curl http://localhost:8000/api/favorites
```

**Response:**
```json
{
    "success": true,
    "count": 5,
    "data": [
        {
            "id": 1,
            "judul": "Nasi Goreng",
            "bahan": "...",
            "langkah": "...",
            "gambar": "/storage/reseps/xxx.jpg"
        }
    ]
}
```

---

### 9. Toggle Favorite
**Endpoint:** `POST /api/reseps/{id}/favorite`

**Request:**
```bash
curl -X POST http://localhost:8000/api/reseps/1/favorite
```

**Response:**
```json
{
    "success": true,
    "message": "Resep ditambahkan ke favorit",
    "is_favorited": true
}
```

---

### 10. Remove from Favorite
**Endpoint:** `DELETE /api/reseps/{id}/favorite`

**Request:**
```bash
curl -X DELETE http://localhost:8000/api/reseps/1/favorite
```

**Response:**
```json
{
    "success": true,
    "message": "Resep dihapus dari favorit"
}
```

---

### 11. Get Current User Info
**Endpoint:** `GET /api/user`

**Request:**
```bash
curl http://localhost:8000/api/user
```

**Response:**
```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2026-01-10T08:00:00Z",
    "updated_at": "2026-01-10T08:00:00Z"
}
```

---

## 📤 Response Format

### Success Response
```json
{
    "success": true,
    "message": "Operation successful",
    "data": { ... }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["validation error"]
    }
}
```

---

## ❌ Error Handling

### Common HTTP Status Codes

| Status | Meaning |
|--------|---------|
| 200 | OK - Success |
| 201 | Created - Resource created |
| 400 | Bad Request - Invalid input |
| 403 | Forbidden - Not authorized |
| 404 | Not Found - Resource doesn't exist |
| 422 | Unprocessable Entity - Validation error |
| 500 | Internal Server Error |

### Validation Errors
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "judul": ["The judul field is required."],
        "bahan": ["The bahan field is required."],
        "gambar": ["The gambar must be an image."]
    }
}
```

---

## 🧪 Testing with Postman/Insomnia

### 1. Import Collection
Create a new environment:
```json
{
    "base_url": "http://localhost:8000/api",
    "user_id": "1"
}
```

### 2. Test Endpoints
- Create a GET request to `{{base_url}}/reseps`
- Create a POST request to `{{base_url}}/reseps` with form data
- Create a PUT request to `{{base_url}}/reseps/1` with updates
- Create a DELETE request to `{{base_url}}/reseps/1`

### 3. JavaScript Fetch Example
```javascript
// Get all reseps
fetch('http://localhost:8000/api/reseps')
    .then(res => res.json())
    .then(data => console.log(data));

// Create new resep
const formData = new FormData();
formData.append('judul', 'Rendang Daging');
formData.append('bahan', 'Daging, Kelapa, Rempah');
formData.append('langkah', '1. Potong daging...');

fetch('http://localhost:8000/api/reseps', {
    method: 'POST',
    body: formData
})
    .then(res => res.json())
    .then(data => console.log(data));

// Search
fetch('http://localhost:8000/api/search?q=nasi')
    .then(res => res.json())
    .then(data => console.log(data));
```

---

## 🚀 Production Deployment

### Enable Sanctum Authentication
```bash
# Install API support
php artisan install:api

# Generate API token for user
$user = User::first();
$token = $user->createToken('api-token')->plainTextToken;
```

### CORS Configuration
Update `config/cors.php` for mobile apps:
```php
'allowed_origins' => ['*'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### Rate Limiting
Add to middleware:
```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

---

## 📝 Notes

- All timestamps are in ISO 8601 format (UTC)
- Image URLs are absolute paths (prepend domain in production)
- Pagination default is 12 items per page
- Search returns max 20 results
- No authentication required for public endpoints (can be added via Sanctum)

---

**Last Updated:** January 13, 2026  
**API Version:** 1.0
