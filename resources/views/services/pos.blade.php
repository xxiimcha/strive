<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Salon POS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @include('pos.partials.styles')
  </style>
</head>
<body>

  @include('pos.partials.header')

  <div class="container-fluid mt-3">
    <div class="row">
      @include('pos.partials.left_column')
      @include('pos.partials.right_column')
    </div>
  </div>

  @include('pos.partials.modals')

  @include('pos.partials.scripts')

</body>
</html>
