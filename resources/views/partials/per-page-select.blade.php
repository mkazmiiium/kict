@php
    $perPage = $perPage ?? 10;
@endphp

<select name="per_page" class="form-select ms-2" style="width: auto;" onchange="this.form.submit()">
  @foreach ([10, 20, 50, 100] as $option)
    <option value="{{ $option }}" {{ (int) $perPage === $option ? 'selected' : '' }}>{{ $option }} / page</option>
  @endforeach
</select>
