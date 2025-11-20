<div class="modal-header">
    <h5 class="modal-title">Edit: {{ $page->title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    @php
        $content = json_decode($page->content, true);
    @endphp

    <form action="{{ route('vcms.update', $page->slug) }}" method="POST">
        @csrf

        @foreach ($content as $key => $value)
            <div class="mb-3">
                <label class="form-label">{{ ucfirst($key) }}</label>

                @if(is_string($value))
                    <input type="text" name="content[{{ $key }}]" class="form-control" value="{{ $value }}">
                @elseif(is_array($value))
                    <textarea name="content[{{ $key }}]" class="form-control" rows="4">{{ json_encode($value, JSON_PRETTY_PRINT) }}</textarea>
                @endif

            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Save</button>
    </form>

</div>
