<div class="form-group col-span-6 sm:col-span-5">
    <label for="{{$title}}">{{$title}}</label>
    <textarea class="form-control @error($model) border-danger @enderror" name="" id="" cols="100" rows="200" style="height: 150px" wire:model.defer="{{$model}}"></textarea>
    @error($model) <span class="error">{{ $message }}</span> @enderror
    @error($model) <span class="error text-danger">{{ $message }}</span> @enderror
</div>
