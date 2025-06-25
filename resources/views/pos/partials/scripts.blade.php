
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
          customer_name: document.getElementById('customerName')?.value || null,
          contact: document.getElementById('contactNumber')?.value || null,
          cash: cash,
          change: parseFloat(document.getElementById('changeOutput').value),
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