<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POS - Service Transaction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-size: 1.2rem;
        }
        .pos-container {
            max-width: 1100px;
            margin: auto;
            padding: 2rem;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
            margin-top: 2rem;
            border-radius: 10px;
        }
        .keypad button {
            font-size: 1.5rem;
            padding: 1rem;
            width: 100%;
        }
        .form-control-lg {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<div class="pos-container">
    <h4 class="mb-4 text-center">Service POS Entry</h4>

    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <div class="row">
            <!-- Keypad Side -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label>Date</label>
                    <input type="text" name="date" class="form-control form-control-lg" value="{{ now()->format('Y-m-d') }}" readonly>
                </div>
                <div class="mb-3">
                    <label>OR #</label>
                    <input type="text" id="or_input" name="or_number" class="form-control form-control-lg" readonly required>
                </div>
                <div class="mb-3">
                    <label>SS #</label>
                    <input type="text" id="ss_input" name="ss_number" class="form-control form-control-lg" readonly>
                </div>

                <div class="keypad text-center mt-4">
                    <div class="row g-2">
                        @foreach([1,2,3,4,5,6,7,8,9] as $num)
                            <div class="col-4">
                                <button type="button" class="btn btn-light" onclick="appendToField('{{ $num }}')">{{ $num }}</button>
                            </div>
                        @endforeach
                        <div class="col-4">
                            <button type="button" class="btn btn-warning" onclick="clearField()">Clear</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-light" onclick="appendToField('0')">0</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-secondary" onclick="deleteLast()">Del</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Table Side -->
            <div class="col-md-8">
                <table class="table table-bordered" id="serviceTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40%">Service</th>
                            <th style="width: 25%">Staff</th>
                            <th style="width: 20%">Amount</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="serviceRows">
                        <tr>
                            <td>
                                <select name="services[]" class="form-control form-control-lg service-select" required onchange="fetchServicePrice(this)">
                                    <option value="" disabled selected>-- Select Service --</option>
                                    @foreach($groupedServices as $group => $items)
                                        <optgroup label="{{ $group }}">
                                            @foreach($items as $service)
                                                <option value="{{ $service['service_name'] }}">{{ $service['service_name'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="staff_list[]" class="form-control form-control-lg" required>
                                    <option value="" disabled selected>-- Select Staff --</option>
                                    @foreach($staff as $person)
                                        <option value="{{ $person }}">{{ $person }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="amounts[]" class="form-control form-control-lg amount-field" readonly>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-outline-primary btn-sm mb-3" onclick="addRow()">+ Add Service</button>
                <button type="submit" class="btn btn-success btn-lg w-100">Submit Transaction</button>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript -->
<script>
    let activeField = 'or_input';

    function appendToField(num) {
        const field = document.getElementById(activeField);
        field.value += num;
    }

    function clearField() {
        document.getElementById(activeField).value = '';
    }

    function deleteLast() {
        const field = document.getElementById(activeField);
        field.value = field.value.slice(0, -1);
    }

    document.getElementById('or_input').addEventListener('focus', () => activeField = 'or_input');
    document.getElementById('ss_input').addEventListener('focus', () => activeField = 'ss_input');

    function removeRow(button) {
        const row = button.closest('tr');
        if (document.querySelectorAll('#serviceRows tr').length > 1) {
            row.remove();
        }
    }

    function addRow() {
        const row = document.querySelector('#serviceRows tr').cloneNode(true);
        row.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        row.querySelector('.amount-field').value = '';
        document.getElementById('serviceRows').appendChild(row);
    }

    function fetchServicePrice(selectElement) {
        const selectedService = selectElement.value;
        const row = selectElement.closest('tr');
        const amountInput = row.querySelector('.amount-field');

        if (!selectedService) return;

        fetch(`/api/service-price?name=${encodeURIComponent(selectedService)}`)
            .then(response => response.json())
            .then(data => {
                amountInput.value = data.price ?? '0.00';
            })
            .catch(() => {
                amountInput.value = '0.00';
            });
    }
</script>

</body>
</html>
