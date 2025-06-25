
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
