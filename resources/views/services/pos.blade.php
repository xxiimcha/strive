<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Salon POS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>

<div class="header-bar">
  <div><strong>USER:</strong> Cashier | <strong>OD:</strong> 1 | <strong>MODE:</strong> Express</div>
  <div><strong>SALON POS</strong></div>
  <div><strong>Date:</strong> <span id="currentDate"></span></div>
</div>

<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-md-6">
      <div class="row mb-3">
        <div class="col-6">
          <label class="form-label">Customer Name:</label>
          <input type="text" id="customerName" class="form-control" placeholder="Enter name">
        </div>
        <div class="col-6">
          <label class="form-label">Contact No:</label>
          <input type="text" id="customerContact" class="form-control" placeholder="Enter contact">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-6">
          <label class="form-label">OR#:</label>
          <input type="text" id="orNumber" class="form-control" placeholder="e.g. 1001" inputmode="numeric">
        </div>
        <div class="col-6">
          <label class="form-label">SS#:</label>
          <input type="text" id="ssNumber" class="form-control" placeholder="e.g. 2025-001" inputmode="numeric">
        </div>
      </div>
      <table class="table table-bordered item-table">
        <thead class="table-primary">
          <tr>
            <th>Item</th>
            <th>Rate</th>
            <th>Qty</th>
            <th>Staff</th>
          </tr>
        </thead>
        <tbody id="itemList"></tbody>
      </table>
      <div class="row">
        <div class="col-md-3 action-btns">
          <button class="btn btn-danger w-100" onclick="removeSelected()">Remove</button>
        </div>
        <div class="col-md-3 action-btns">
          <button class="btn btn-outline-dark w-100" onclick="window.location.reload()">New Bill</button>
        </div>
        <div class="col-md-3 action-btns">
          <button class="btn btn-warning w-100" onclick="voidLastItem()">Void Item</button>
        </div>
        <div class="col-md-3 action-btns">
          <button class="btn btn-secondary w-100" onclick="refundLastTransaction()">Refund Last</button>
        </div>
        <div class="col-md-12 mt-2">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="scDiscountToggle" onchange="updateTotal()">
            <label class="form-check-label" for="scDiscountToggle">
              Apply Senior Citizen Discount (20%)
            </label>
          </div>
        </div>
      </div>
      <div class="summary-box p-3 border rounded bg-light mt-2">
        <div class="mb-2">
          <label>Discount %</label>
          <input type="number" class="form-control" value="0.00" disabled>
        </div>
        <div class="mb-2">
          <label>Loyalty Points</label>
          <input type="text" class="form-control" value="0" disabled>
        </div>
        <div class="mb-2">
          <label>Grand Total</label>
          <input type="text" id="grandTotal" class="form-control" value="0.00" readonly>
        </div>
        <div class="mb-2">
          <label>Cash</label>
          <input type="text" class="form-control" id="cashInput" placeholder="Enter Cash" oninput="updateTotal()">
        </div>
        <div class="mb-2">
          <label>Change</label>
          <input type="text" class="form-control" id="changeOutput" value="0.00" readonly>
        </div>
        <div class="mt-3">
          <button class="btn btn-success w-100" onclick="finalizeTransaction()">Finalize Transaction (Cash)</button>
        </div>
      </div>
    </div>
    <!-- Right Column -->
    <div class="col-md-6">
      <div class="row fixed-service-row">
        @php $categories = []; @endphp
        <div class="col-4 category-panel">
          @foreach($groupedServices as $key => $services)
            @php 
              $cat = explode(' - ', $key)[0];
              if (!in_array($cat, $categories)) {
                $categories[] = $cat;
              }
            @endphp
          @endforeach

          @foreach($categories as $cat)
            <button class="btn btn-primary" onclick="filterCategory('{{ $cat }}', this)">{{ strtoupper($cat) }}</button>
          @endforeach
        </div>

        <div class="col-8 service-buttons" id="serviceButtons">
          @foreach($groupedServices as $groupKey => $services)
            @foreach($services as $service)
              <button 
                class="btn btn-light" 
                data-category="{{ $service['category'] }}"
                onclick="addToList(`{{ $service['service_name'] }} ({{ $service['length_type'] }})`, {{ $service['price'] ?? 0 }}, {{ $service['is_quoted'] }})">
                {{ $service['service_name'] }} <small>({{ $service['length_type'] }})</small>
              </button>
            @endforeach
          @endforeach
        </div>
      </div>

      <!-- Keypad -->
      <div class="row mt-3">
        <div class="col-12">
          <div class="card p-2">
            <div class="row g-1">
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('1')">1</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('2')">2</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('3')">3</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('4')">4</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('5')">5</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('6')">6</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('7')">7</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('8')">8</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('9')">9</button></div>
              <div class="col-4"><button class="btn btn-outline-warning w-100" onclick="pressKeypad('0')">0</button></div>
              <div class="col-4"><button class="btn btn-outline-secondary w-100" onclick="pressKeypad('.')">.</button></div>
              <div class="col-4"><button class="btn btn-outline-danger w-100" onclick="pressKeypad('back')">←</button></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Refund Transactions by SS#</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="refundContent">
        <p class="text-muted">Loading...</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" onclick="submitSelectedRefunds()">Refund Selected Items</button>
      </div>
    </div>
  </div>
</div>

<!-- Refund Reason Modal -->
<div class="modal fade" id="refundReasonModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Enter Reason for Refund</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <textarea id="refundReason" class="form-control" rows="3" placeholder="Describe reason for refund..." required></textarea>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmRefundBtn">Confirm Refund</button>
      </div>
    </div>
  </div>
</div>

<!-- Custom Price Modal -->
<div class="modal fade" id="customPriceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enter Custom Price</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="customPriceInput" class="form-control mb-3" placeholder="0.00" inputmode="decimal">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-sm" id="confirmCustomPriceBtn">Add Item</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const staffList = @json($staff);
  document.getElementById('currentDate').textContent = new Date().toLocaleString();
  let pendingItem = null;

  function addToList(name, price, isQuoted = 0) {
    if (isQuoted === 1) {
      pendingItem = { name, price };
      document.getElementById('customPriceInput').value = price.toFixed(2);
      new bootstrap.Modal(document.getElementById('customPriceModal')).show();
    } else {
      addItemToList(name, price);
    }
  }

  document.getElementById('confirmCustomPriceBtn').addEventListener('click', () => {
    const input = parseFloat(document.getElementById('customPriceInput').value);
    if (isNaN(input) || input <= 0) return;
    bootstrap.Modal.getInstance(document.getElementById('customPriceModal')).hide();
    if (pendingItem) {
      addItemToList(pendingItem.name, input);
      pendingItem = null;
    }
  });

  function addItemToList(name, price) {
    const tbody = document.getElementById('itemList');
    const tr = document.createElement('tr');
    const staffOptions = staffList.map(staff => `<option value="${staff}">${staff}</option>`).join('');

    tr.innerHTML = `
      <td>${name}</td>
      <td>${price.toFixed(2)}</td>
      <td>1</td>
      <td><select class="form-select form-select-sm"><option disabled selected>Select Staff</option>${staffOptions}</select></td>
    `;
    tbody.appendChild(tr);
    updateTotal();
  }

  function removeSelected() {
    const tbody = document.getElementById('itemList');
    if (tbody.lastChild) {
      tbody.removeChild(tbody.lastChild);
      updateTotal();
    }
  }

  function updateTotal() {
    let total = 0;
    document.querySelectorAll('#itemList tr').forEach(row => {
      const rate = parseFloat(row.children[1].innerText);
      const qty = parseInt(row.children[2].innerText);
      total += rate * qty;
    });

    document.getElementById('grandTotal').value = total.toFixed(2);
    const cashInput = parseFloat(document.getElementById('cashInput').value) || 0;
    const change = cashInput - total;
    document.getElementById('changeOutput').value = change >= 0 ? change.toFixed(2) : '0.00';
  }

  function finalizeTransaction() {
    const total = parseFloat(document.getElementById('grandTotal').value);
    const cash = parseFloat(document.getElementById('cashInput').value);
    const ssNumber = document.getElementById('ssNumber').value.trim();
    const orNumber = document.getElementById('orNumber').value.trim();

    if (!ssNumber) return alert("SS# is required.");
    if (isNaN(cash) || cash < total) return alert("Cash is insufficient.");
    
    const rows = document.querySelectorAll('#itemList tr');
    const items = [];

    rows.forEach(row => {
        const itemName = row.children[0].innerText;
        const itemRate = parseFloat(row.children[1].innerText);
        const quantity = parseInt(row.children[2].innerText);
        const staffSelect = row.children[3].querySelector('select');
        const staffName = staffSelect ? staffSelect.value : null;

        items.push({
        item_name: itemName,
        item_rate: itemRate,
        quantity: quantity,
        staff_name: staffName
        });
    });

    if (items.length === 0) return alert("Please add at least one item.");

    fetch('/save-transaction', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
        ss_number: ssNumber,
        or_number: orNumber,
        items: items
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Failed to save transaction');
        return response.json();
    })
    .then(data => {
        alert('Transaction saved successfully!\nTransaction #: ' + data.transaction_number);
        window.location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred while saving the transaction.');
    });
    }


  function filterCategory(cat, btnElement) {
    document.querySelectorAll('#serviceButtons button').forEach(btn => {
      btn.style.display = btn.dataset.category === cat ? 'inline-block' : 'none';
    });

    document.querySelectorAll('.category-panel button').forEach(btn => {
      btn.classList.remove('active-category');
    });

    if (btnElement) {
      btnElement.classList.add('active-category');
    }
  }

  function pressKeypad(value) {
    const modal = document.getElementById('customPriceModal');
    const input = modal.classList.contains('show')
      ? document.getElementById('customPriceInput')
      : document.getElementById('cashInput');

    if (value === 'back') {
      input.value = input.value.slice(0, -1);
    } else {
      input.value += value;
    }

    if (!modal.classList.contains('show')) updateTotal();
  }

  // Input sanitization
  document.getElementById('orNumber').addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  document.getElementById('ssNumber').addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9\-]/g, '');
  });

  let refundedTransactions = [];

  function promptSSNumber(action, callback) {
    const ssNumber = document.getElementById('ssNumber').value.trim();
    if (!ssNumber) {
      alert(`Please enter a valid SS# before attempting to ${action}.`);
      return;
    }
    if (confirm(`${action} will be processed for SS#: ${ssNumber}. Proceed?`)) {
      callback();
    }
  }

  function voidLastItem() {
    promptSSNumber('Void Item', () => {
      const tbody = document.getElementById('itemList');
      if (tbody.lastChild) {
        tbody.removeChild(tbody.lastChild);
        updateTotal();
      }
    });
  }

function refundLastTransaction() {
  const ssNumber = document.getElementById('ssNumber').value.trim();
  if (!ssNumber) return alert("Please enter an SS#.");

  fetch(`/api/refund-transactions/${encodeURIComponent(ssNumber)}`)
    .then(res => res.json())
    .then(data => {
      const content = document.getElementById('refundContent');
      if (!data || data.length === 0) {
        content.innerHTML = `<div class="alert alert-warning">No completed transactions found for SS#: ${ssNumber}</div>`;
        return new bootstrap.Modal(document.getElementById('refundModal')).show();
      }

      const grouped = {};
      data.forEach(row => {
        if (!grouped[row.transaction_number]) grouped[row.transaction_number] = [];
        grouped[row.transaction_number].push(row);
      });

      let html = '';
      for (const [txn, items] of Object.entries(grouped)) {
        html += `<div class="mb-3 border rounded p-2">
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Transaction #: ${txn}</h6>
            <button class="btn btn-sm btn-outline-danger" onclick="refundWholeTransaction('${txn}')">Refund Whole Transaction</button>
          </div>
          <table class="table table-sm table-bordered mt-2">
            <thead><tr><th></th><th>Item</th><th>Rate</th><th>Qty</th><th>Staff</th></tr></thead>
            <tbody>`;
        items.forEach(item => {
          html += `<tr>
            <td><input type="checkbox" class="refund-item" data-id="${item.id}"></td>
            <td>${item.item_name}</td>
            <td>₱${parseFloat(item.item_rate).toFixed(2)}</td>
            <td>${item.quantity}</td>
            <td>${item.staff_name || '-'}</td>
          </tr>`;
        });
        html += `</tbody></table></div>`;
      }

      content.innerHTML = html;
      new bootstrap.Modal(document.getElementById('refundModal')).show();
    })
    .catch(err => {
      console.error(err);
      document.getElementById('refundContent').innerHTML = `<div class="alert alert-danger">Error loading transactions.</div>`;
      new bootstrap.Modal(document.getElementById('refundModal')).show();
    });
}

function submitSelectedRefunds() {
  const selectedIds = [...document.querySelectorAll('.refund-item:checked')].map(cb => cb.dataset.id);
  if (selectedIds.length === 0) return alert("Please select at least one item to refund.");

  // Show reason modal first
  document.getElementById('refundReason').value = ''; // Clear previous
  const confirmBtn = document.getElementById('confirmRefundBtn');
  
  confirmBtn.onclick = () => {
    const reason = document.getElementById('refundReason').value.trim();
    if (!reason) return alert("Refund reason is required.");

    fetch('/api/refund-items', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ ids: selectedIds, reason })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      bootstrap.Modal.getInstance(document.getElementById('refundReasonModal')).hide();
      bootstrap.Modal.getInstance(document.getElementById('refundModal')).hide();
    })
    .catch(err => {
      console.error(err);
      alert("Error processing refund.");
    });
  };

  new bootstrap.Modal(document.getElementById('refundReasonModal')).show();
}

function refundWholeTransaction(txn) {
  document.getElementById('refundReason').value = '';
  const confirmBtn = document.getElementById('confirmRefundBtn');

  confirmBtn.onclick = () => {
    const reason = document.getElementById('refundReason').value.trim();
    if (!reason) return alert("Refund reason is required.");

    fetch(`/api/refund-transaction/${txn}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ reason })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      bootstrap.Modal.getInstance(document.getElementById('refundReasonModal')).hide();
      bootstrap.Modal.getInstance(document.getElementById('refundModal')).hide();
    })
    .catch(err => {
      console.error(err);
      alert("Error refunding entire transaction.");
    });
  };

  new bootstrap.Modal(document.getElementById('refundReasonModal')).show();
}

  function updateTotal() {
    let total = 0;
    document.querySelectorAll('#itemList tr').forEach(row => {
      const rate = parseFloat(row.children[1].innerText);
      const qty = parseInt(row.children[2].innerText);
      total += rate * qty;
    });
    const isSenior = document.getElementById('scDiscountToggle')?.checked;
    if (isSenior) total *= 0.80;
    document.getElementById('grandTotal').value = total.toFixed(2);
    const cashInput = parseFloat(document.getElementById('cashInput').value) || 0;
    const change = cashInput - total;
    document.getElementById('changeOutput').value = change >= 0 ? change.toFixed(2) : '0.00';
  }
</script>
</body>
</html>
