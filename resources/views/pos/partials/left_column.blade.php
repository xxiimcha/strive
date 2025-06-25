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