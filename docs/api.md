# Healthcare Appointment API Documentation

## Overview
Complete API documentation for the Healthcare Appointment Booking system. This API allows users to register, authenticate, view healthcare professionals, and manage appointments.

**Base URL:** `http://localhost:8000/api`

## Authentication
The API uses Bearer token authentication. Include the token in the Authorization header for protected endpoints.

```
Authorization: Bearer {token}
```

## Endpoints

### Authentication

#### Register User
Register a new user account.

- **URL:** `/register`
- **Method:** `POST`
- **Auth Required:** No
- **Content-Type:** `application/json`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Success Response:**
- **Code:** 201
- **Content:** User registration confirmation

---

#### Login User
Authenticate user and receive access token.

- **URL:** `/login`
- **Method:** `POST`
- **Auth Required:** No
- **Content-Type:** `application/json`

**Request Body:**
```json
{
    "email": "john.doe@example.com",
    "password": "password123"
}
```

**Success Response:**
- **Code:** 200
- **Content:** 
```json
{
    "token": "your-auth-token-here",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john.doe@example.com"
    }
}
```

---

### Healthcare Professionals

#### List Healthcare Professionals
Get a list of all available healthcare professionals.

- **URL:** `/healthcare-professionals`
- **Method:** `GET`
- **Auth Required:** No

**Success Response:**
- **Code:** 200
- **Content:** Array of healthcare professional objects

---

### Appointments

#### Book Appointment
Create a new appointment with a healthcare professional.

- **URL:** `/appointments`
- **Method:** `POST`
- **Auth Required:** Yes
- **Content-Type:** `application/json`

**Request Body:**
```json
{
    "healthcare_professional_id": 1,
    "appointment_start_time": "2025-08-05 11:15:00",
    "appointment_end_time": "2025-08-05 12:00:00",
    "notes": "Regular checkup"
}
```

**Required Fields:**
- `healthcare_professional_id` (integer): ID of the healthcare professional
- `appointment_start_time` (datetime): Start time in format YYYY-MM-DD HH:MM:SS
- `appointment_end_time` (datetime): End time in format YYYY-MM-DD HH:MM:SS
- `notes` (string, optional): Additional notes for the appointment

**Success Response:**
- **Code:** 201
- **Content:** Created appointment details

---

#### List My Appointments
Get all appointments for the authenticated user.

- **URL:** `/appointments`
- **Method:** `GET`
- **Auth Required:** Yes

**Success Response:**
- **Code:** 200
- **Content:** Array of user's appointment objects

---

#### Cancel Appointment
Cancel an existing appointment.

- **URL:** `/appointments/{id}/cancel`
- **Method:** `PATCH`
- **Auth Required:** Yes

**URL Parameters:**
- `id` (integer): The appointment ID to cancel

**Success Response:**
- **Code:** 200
- **Content:** Updated appointment with cancelled status

---

#### Complete Appointment
Mark an appointment as completed.

- **URL:** `/appointments/{id}/complete`
- **Method:** `PATCH`
- **Auth Required:** Yes

**URL Parameters:**
- `id` (integer): The appointment ID to complete

**Success Response:**
- **Code:** 200
- **Content:** Updated appointment with completed status

---

## Error Responses

### Common Error Codes
- **400 Bad Request:** Invalid request data
- **401 Unauthorized:** Authentication required or invalid token
- **403 Forbidden:** Access denied
- **404 Not Found:** Resource not found
- **422 Unprocessable Entity:** Validation errors
- **500 Internal Server Error:** Server error

### Error Response Format
```json
{
    "message": "Error description",
    "errors": {
        "field_name": ["Validation error message"]
    }
}
```

---

## Environment Variables

### Postman Collection Variables
- `base_url`: `http://localhost:8000/api`
- `auth_token`: Automatically set after successful login

---

## Usage Examples

### Complete Authentication Flow
1. Register a new user using the `/register` endpoint
2. Login using the `/login` endpoint to receive an authentication token
3. The token will be automatically stored and used for subsequent requests

### Booking an Appointment
1. Ensure you are authenticated (have a valid token)
2. Get list of healthcare professionals using `/healthcare-professionals`
3. Book an appointment using `/appointments` with the desired professional's ID
4. View your appointments using the GET `/appointments` endpoint
5. Cancel or complete appointments using the respective PATCH endpoints

---

## Notes

- All datetime fields should be in the format: `YYYY-MM-DD HH:MM:SS`
- The API uses Bearer token authentication for protected endpoints
- Tokens are automatically managed in the Postman collection after login
- Make sure to include proper Content-Type headers for POST requests