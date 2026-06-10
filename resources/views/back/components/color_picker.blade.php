<div class="form-group">
    <label>{{ $label }}</label>
    <div class="d-flex align-items-center" style="gap:8px;">
        <input type="color"
               name="{{ $name }}"
               id="{{ $id }}"
               class="banner-color-picker"
               data-preview="{{ $id }}_preview"
               data-for-name="{{ $forName }}"
               value="{{ $value ?? '#ffffff' }}"
               style="height:38px;width:70px;padding:2px 4px;cursor:pointer;border:1px solid #ddd;border-radius:4px;">
        <span id="{{ $id }}_preview"
              style="padding:4px 14px;border-radius:4px;background:#2d3748;font-weight:600;font-size:13px;
                     color:{{ $value ?? '#ffffff' }};">
            {{ $preview ?? 'Preview' }}
        </span>
    </div>
</div>
