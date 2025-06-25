
<style>
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', sans-serif;
    }
    .header-bar {
      background-color: #007bff;
      color: white;
      padding: 0.5rem 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .item-table th, .item-table td {
      font-size: 0.9rem;
      vertical-align: middle;
    }
    .summary-box input {
      text-align: right;
    }
    .summary-box {
      font-size: 1rem;
    }
    .action-btns .btn {
      margin: 5px 0;
      font-size: 0.9rem;
      border-radius: 0 !important;
    }
    .fixed-service-row {
      height: 450px;
      overflow: hidden;
    }
    .fixed-service-row .category-panel,
    .fixed-service-row .service-buttons {
      height: 100%;
      overflow-y: auto;
    }

    /* Enhanced Category Button Styling */
    .category-panel {
      padding-right: 10px;
    }
    .category-panel button {
      margin-bottom: 8px;
      font-size: 0.85rem;
      font-weight: 600;
      width: 100%;
      text-align: center;
      white-space: normal;
      transition: background-color 0.2s ease-in-out;
    }
    .category-panel button:hover {
      background-color: #0056b3 !important;
    }
    .category-panel button.active-category {
      background-color: #ffc107 !important;
      color: #000;
      border: 1px solid #ffc107;
    }

    /* Enhanced Service Button Grid */
    .service-buttons {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: 8px;
      padding-right: 10px;
    }
    .service-buttons .btn {
      font-size: 0.82rem;
      font-weight: 500;
      text-align: center;
      white-space: normal;
      padding: 0.5rem;
      transition: background-color 0.2s ease-in-out;
    }
    .service-buttons .btn:hover {
      background-color: #e0e0e0;
    }
  </style>