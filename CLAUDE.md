# Shopping Service BI Dashboard

## Project Overview
A Laravel-based Business Intelligence dashboard for a Philippine scale model retail business.

## Tech Stack
- Framework: Laravel (PHP)
- Frontend: Bootstrap + Bootstrap Icons + Chart.js
- Database: MySQL on port 3306
- Server: php artisan serve (port 8000)

## Databases

### Source: shopping_service
- customers, products, productlines, offices, employees, orders, orderdetails, payments

### Data Warehouse: shopping_service_dimensional_models
- Dimension tables: customer_dim, product_dim, order_dim, employee_dim, productline_dim
- Fact tables: fact_q1, fact_q2, fact_q3, fact_q4, fact_q5

## Business Questions
- Q1: Which city is the best market for sales?
- Q2: Which product has the highest sales?
- Q3: Which office provides the best sales support?
- Q4: Which product line generates the most revenue?
- Q5: Which sales representative has the most orders handled?

## Dashboard Layout

### KPI Cards (top row — 4 cards)
- Total revenue (in Philippine Peso ₱)
- Total orders
- Total customers
- Total products

### Chart Layout
- Row 1: Q1 City sales (bar chart) | Q3 Office sales support (doughnut chart)
- Row 2: Q2 Top products by sales (horizontal bar chart — full width)
- Row 3: Q4 Product line revenue (bar chart) | Q5 Sales rep performance (dual-axis bar chart)
- Row 4: Monthly sales trend (line chart — full width)

### Filters
- Period filter (grouped):
  - Quarterly: Q1 (Jan–Mar), Q2 (Apr–Jun), Q3 (Jul–Sep), Q4 (Oct–Dec)
  - Semi-annual: H1 (Jan–Jun), H2 (Jul–Dec)
  - Annual: 2025 (default)
- Location filter: All cities, Quezon City, Davao City, Taguig, Pasig, Cebu City
- Q3, Q4, and H2 show empty state — "No data for this period"

## Environment
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=shopping_service_dimensional_models
- DB_USERNAME=root
- DB_PASSWORD=
- SESSION_DRIVER=file
- Timezone: Asia/Manila

## Key Notes
- All prices are in Philippine Peso (₱)
- Data covers Jan–Apr 2025 only
- Bootstrap and Bootstrap Icons already installed via npm
- Assets already built via npm run build