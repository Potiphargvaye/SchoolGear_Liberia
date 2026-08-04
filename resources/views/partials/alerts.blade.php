{{-- Success Alert (ignore login messages) --}}
@if (session('success') && !session()->has('login_success'))
<div class="mb-6 p-4 rounded-lg bg-green-100 border-l-4 border-green-500 text-green-700">
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif

{{-- Error Alert --}}
@if (session('error'))
<div class="mb-6 p-4 rounded-lg bg-red-100 border-l-4 border-red-500 text-red-700">
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
<div class="mb-6 p-4 rounded-lg bg-red-100 border-l-4 border-red-500 text-red-700">
    <div class="flex justify-between items-center">
        <div>
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">Please fix these issues:</span>
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.parentElement.remove()">
            <i class="fas fa-times">close</i>
        </button>
    </div>
</div>
@endif
