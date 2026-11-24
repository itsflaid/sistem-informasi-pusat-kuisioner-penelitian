<x-app-layout>
    <x-slot name="header"><x-page-header title="Edit tautan kuesioner" description="Perbarui informasi dan tautan kuesioner eksternal." /></x-slot>
    <form method="POST" action="{{ route('questionnaires.update', $questionnaire) }}">@csrf @method('PUT')
        <div class="card shadow-sm"><div class="card-body p-4"><div class="row g-3">
            <div class="col-12"><x-field for="title" label="Judul" :error="$errors->first('title')"><input class="form-control" id="title" name="title" value="{{ old('title', $questionnaire->title) }}" required></x-field></div>
            <div class="col-md-6"><x-field for="category_id" label="Kategori" :error="$errors->first('category_id')"><select class="form-select" id="category_id" name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $questionnaire->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></x-field></div>
            <div class="col-md-3"><x-field for="estimated_minutes" label="Estimasi menit" :error="$errors->first('estimated_minutes')"><input class="form-control" id="estimated_minutes" type="number" min="1" name="estimated_minutes" value="{{ old('estimated_minutes', $questionnaire->estimated_minutes) }}"></x-field></div>
            <div class="col-md-3"><x-field for="target_respondents" label="Target responden" :error="$errors->first('target_respondents')"><input class="form-control" id="target_respondents" type="number" min="1" name="target_respondents" value="{{ old('target_respondents', $questionnaire->target_respondents) }}"></x-field></div>
            <div class="col-md-6"><x-field for="deadline_at" label="Batas waktu" :error="$errors->first('deadline_at')"><input class="form-control" id="deadline_at" type="date" name="deadline_at" value="{{ old('deadline_at', $questionnaire->deadline_at->toDateString()) }}" required></x-field></div>
            <div class="col-12"><x-field for="external_url" label="Tautan kuesioner" :error="$errors->first('external_url')"><input class="form-control" id="external_url" type="url" name="external_url" value="{{ old('external_url', $questionnaire->external_url) }}" required></x-field></div>
            <div class="col-12"><x-field for="description" label="Deskripsi" :error="$errors->first('description')"><textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $questionnaire->description) }}</textarea></x-field></div>
        </div><x-button type="submit" class="mt-4">Simpan perubahan</x-button></div></div>
    </form>
</x-app-layout>
