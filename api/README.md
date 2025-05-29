# API Documentation

## Base URL
```
https://localhost/api/
```

## Authentication
The API uses cookie-based session authentication. Most endpoints require authentication.

### Headers
```
Content-Type: application/json
Access-Control-Allow-Credentials: true
```

---

## Authentication Endpoints

### 1. User Registration
**POST** `/register/`

Register a new user account.

**Request Body:**
```json
{
  "username": "string",
  "password": "string", 
  "email": "string",
  "phone": "string"
}
```

**Response:**
- `200`: "New user created"
- `400`: "username already exists"

---

### 2. User Login
**POST** `/login/`

Authenticate user and create session.

**Request Body:**
```json
{
  "username": "string",
  "password": "string"
}
```

**Response:**
- `200`: "success" (sets session cookie)
- Admin users are redirected to admin panel

---

### 3. User Logout
**POST** `/logout.php`

End user session.

**Response:**
- `200`: "cookie moved"

---

## User Management

### 4. Get User Info
**GET** `/userinfo.php`

Get current user's profile information.

**Response:**
```json
{
  "username": "string",
  "email": "string", 
  "phone_number": "string",
  "bg_image": "string",
  "pf_image": "string",
  "noti": boolean
}
```

---

### 5. Update Profile
**POST** `/update_profile.php`

Update user profile information.

**Request Body:**
```json
{
  "username": "string",
  "email": "string",
  "phoneNumber": "string"
}
```

**Response:**
- `200`: Success
- `403`: Username already exists

---

### 6. Upload Profile Image
**POST** `/profile_image.php`

Upload user profile picture.

**Request:** `multipart/form-data`
- `profile_image`: Image file

**File Requirements:**
- Formats: JPG, JPEG, PNG
- Max size: 2MB

---

### 7. Upload Background Image
**POST** `/update_bg_img.php`

Upload user background image.

**Request:** `multipart/form-data`
- `bg`: Image file

---

## Item Management

### 8. Get All Items
**GET** `/all_item.php`

Retrieve all active marketplace items.

**Response:**
```json
[
  {
    "item_id": 1,
    "user_id": 1,
    "item_name": "string",
    "item_description": "string",
    "item_price": 100,
    "item_image_dir": "string",
    "view_count": 10,
    "date_posted": "2023-01-01 12:00:00",
    "item_state": "active"
  }
]
```

---

### 9. Get Item Details
**GET** `/item.php?var={item_id}`

Get detailed information about a specific item.

**Response:**
```json
{
  "item_id": 1,
  "item_name": "string",
  "item_description": "string", 
  "item_price": 100,
  "item_contact": "string",
  "view_count": 10,
  "islike": boolean,
  "item_images": [
    {"image_name": "string"}
  ]
}
```

---

### 10. Post New Item
**POST** `/post_item.php`

Create a new marketplace listing.

**Request:** `multipart/form-data`
- `images`: Image file
- `item_info`: JSON string with item details

**Item Info JSON:**
```json
{
  "item_name": "string",
  "description": "string",
  "price": 100,
  "contact": "string"
}
```

---

### 11. Add Item Images
**POST** `/item.php?var={item_id}`

Add additional images to existing item.

**Request:** `multipart/form-data`
- `add_image`: Image file

---

### 12. Get User's Items
**GET** `/my_items.php`

Get all items posted by current user.

**Response:** Array of item objects

---

### 13. Delete Item
**POST** `/delete.php`

Mark item as deleted.

**Request Body:**
```json
{
  "item_id": 123
}
```

---

### 14. Search Items
**POST** `/search.php`

Search items by keyword.

**Request Body:**
```json
{
  "keyword": "string"
}
```

**Response:** Array of matching items

---

## User Interactions

### 15. Like/Unlike Item
**POST** `/likeitem.php`

Toggle like status for an item.

**Request Body:**
```json
{
  "item_id": 123
}
```

---

### 16. Get Liked Items
**GET** `/likeitem.php`

Get all items liked by current user.

**Response:** Array of liked items

---

### 17. Add Comment
**POST** `/comments.php`

Add comment to an item.

**Request Body:**
```json
{
  "item_id": 123,
  "comment": "string"
}
```

---

### 18. Get Comments
**GET** `/comments.php?item_id={item_id}`

Get all comments for an item.

**Response:**
```json
[
  {
    "username": "string",
    "comment_text": "string", 
    "time_created": "2023-01-01 12:00:00"
  }
]
```

---

## User History

### 19. View History
**GET** `/view_history.php`

Get user's item viewing history.

**Response:**
```json
[
  {
    "item_name": "string",
    "item_price": 100,
    "item_image_dir": "string",
    "item_id": 1,
    "time_created": "2023-01-01 12:00:00"
  }
]
```

---

## Notifications

### 20. Get Notifications
**GET** `/notification.php`

Get notifications for deleted liked items.

**Response:** Array of deleted items that user had liked

---

## Admin Features

### 21. Report Item
**POST** `/nmsl.php`

Report an item for review.

**Request Body:**
```json
{
  "reporter": "username",
  "item_id": 123
}
```

---

### 22. Get Reports
**GET** `/get_table.php`

Get all reported items (admin only).

**Response:**
```json
[
  {
    "report_id": 1,
    "item_id": 123,
    "reporter": "username"
  }
]
```

---

### 23. Notice Management
**GET** `/notice.php`

Get latest notice.

**POST** `/notice.php`

Create new notice.

**Request Body:**
```json
{
  "information": "string"
}
```

---

## Error Responses

### HTTP Status Codes
- `200`: Success
- `401`: Unauthorized (not logged in)
- `403`: Forbidden (insufficient permissions)
- `404`: Not Found
- `405`: Method Not Allowed
