
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