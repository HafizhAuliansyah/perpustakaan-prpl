@extends('layouts.perpustakaan')
@section('body')
<div class="container-ulasan">
    <form action={{ route('pengunjung.save.ulasan') }} method="post">
        @csrf
        <div class="form-group">
            <label class="lb-lg text-secondary" for="Masukan">Masukan Ulasan Anda</label>
            <textarea class="form-control" id="Masukan" rows="10" name="masukan"></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-block mb-2"><i class="fa fa-save mr-2"></i>Save</button>
    </form>
</div>

@endsection