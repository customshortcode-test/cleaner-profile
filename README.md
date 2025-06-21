# Cleaner Profile WordPress Plugin

A lightweight WordPress plugin that outputs cleaner profile blocks using a shortcode. Profiles are stored as rows in a semicolon-delimited CSV file, with a simple admin interface to add new entries.

---

## 🔧 Features

- ✅ **Shortcode Output:**  
  Use `[cleaner_profile file="/wp-content/uploads/data.csv"]` to display a responsive Tailwind-styled table of cleaner profiles.

- ✅ **Data Source:**  
  Reads cleaner profiles from a CSV file, with semicolon-delimited fields (acting like a JSON array per row).

- ✅ **Admin Interface:**  
  Adds a “Cleaner Profiles” menu in the WordPress admin where new profiles can be added via a form.

- ✅ **Responsive UI:**  
  Output is styled using Tailwind CSS and is mobile-friendly by default.

- ✅ **Fields Included:**
  - Photo (URL)
  - Name
  - Rating (1–5)
  - Availability (e.g., “Weekdays: 9am–5pm”)
  - Bio

---

## 📦 Installation

1. Download or clone the plugin into the `wp-content/plugins/` directory.
2. Activate it from the **Plugins** section in the WordPress dashboard.
3. Ensure `wp-content/uploads/` is writable. The `data.csv` file will be created on first form submission if not present.

---

## 🧪 Usage

Add the shortcode to any post, page, or widget block:

```php
[cleaner_profile file="/wp-content/uploads/data.csv"]
```

---

## 🛠 Admin Panel

- Go to Cleaner Profiles in the WordPress dashboard sidebar.
- Fill out the form with:
  - **Photo URL:** Image of the cleaner
  - **Name**
  - **Rating:** A number between 1 and 5
  - **Availability:** (e.g., "Weekdays: 9am–5pm")
  - **Bio**
- Submitted entries are:
  - Validated for completeness and correct formatting

---

## 📁 CSV Format
The CSV uses ; (semicolon) as a delimiter. Each row is wrapped in double quotes and represents a single cleaner profile.

**Format:** 

```php
"uuid";"photo_url";"name";"rating";"availability";"bio"
```

**Example:** 

```php
"ad18ef45-2b9f-4004-9e05-c286176a6dbe";"https://loremflickr.com/640/480?lock=1";"Jane Doe";"4.8";"Weekdays: 9am–5pm";"Experienced housekeeper with 5+ years of residential cleaning."
```