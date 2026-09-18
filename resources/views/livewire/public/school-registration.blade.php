<div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6 sm:p-8">

    @include('partials.notifications')

    {{-- Step indicator --}}
    <div class="flex items-center justify-between mb-8">
        @foreach (['School Information', 'Owner Details', 'Review & Create'] as $index => $label)
            @php $stepNum = $index + 1; @endphp
            <div
                class="flex-1 flex items-center {{ $index < 2 ? 'after:content-[\'\'] after:flex-1 after:h-0.5 after:mx-2 ' . ($step > $stepNum ? 'after:bg-sg-primary' : 'after:bg-slate-200') : '' }}">
                <div class="flex flex-col items-center shrink-0">
                    <div
                        class="h-8 w-8 rounded-full flex items-center justify-center text-sm font-semibold
                        {{ $step === $stepNum ? 'bg-sg-primary text-white' : ($step > $stepNum ? 'bg-sg-primary/20 text-sg-primary' : 'bg-slate-100 text-slate-400') }}">
                        @if ($step > $stepNum)
                            <i class="fas fa-check text-xs"></i>
                        @else
                            {{ $stepNum }}
                        @endif
                    </div>
                    <span class="text-xs mt-1.5 text-slate-500 hidden sm:block text-center">{{ $label }}</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Step 1 — School Information --}}
    @if ($step === 1)
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">School Name</label>
                <input type="text" wire:model="school_name" placeholder="e.g. EDMOL Memorial Baptists High School"
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                @error('school_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">School Email</label>
                <input type="email" wire:model="school_email" placeholder="info@yourschool.edu.lr"
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                @error('school_email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
                    <input type="text" wire:model="phone" placeholder="+231 77 000 0000"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">City</label>
                    <input type="text" wire:model="city" placeholder="Monrovia"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                    @error('city')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
                <input type="text" wire:model="address" placeholder="Street, community"
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                @error('address')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Country</label>
                <input type="text" wire:model="country"
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                @error('country')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ADD THIS BLOCK --}}
            <div class="grid grid-cols-1 sm:grid-cols-[auto,1fr] gap-4 items-start">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">School Logo</label>
                    <div class="flex items-center gap-3">
                        <div
                            class="h-14 w-14 shrink-0 rounded-lg border border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden">
                            @if ($logo)
                                <img src="{{ $logo->temporaryUrl() }}" class="h-full w-full object-cover">
                            @else
                                <i class="fas fa-image text-slate-300"></i>
                            @endif
                        </div>
                        <div>
                            <input type="file" wire:model="logo" accept="image/*"
                                class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-sg-bg file:text-sg-primaryDark hover:file:bg-slate-200">
                            <p wire:loading wire:target="logo" class="text-xs text-sg-sky mt-1 flex items-center gap-1">
                                <i class="fas fa-spinner fa-spin"></i> Uploading...
                            </p>
                            @error('logo')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Acronym <span class="text-slate-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" wire:model="short_name" maxlength="20" placeholder="e.g. EMBHS"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                    @error('short_name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            {{-- END ADDED BLOCK --}}

            <div class="pt-4 flex justify-end">
                <button wire:click="nextStep" type="button" wire:loading.attr="disabled" wire:target="nextStep"
                    class="bg-gradient-to-r from-sg-primary to-sg-sky text-white font-semibold px-8 py-3 rounded-lg text-sm hover:brightness-105 transition disabled:opacity-70">
                    Continue
                </button>
            </div>
        </div>
    @endif

    {{-- Step 2 — School Owner Details --}}
    @if ($step === 2)
        <div class="space-y-4" x-data="{
            password: @entangle('owner_password').live,
            confirm: @entangle('owner_password_confirmation').live,
            showPassword: false,
            showConfirm: false,
            get matchState() {
                if (!this.confirm) return null;
                return this.password === this.confirm ? 'match' : 'mismatch';
            }
        }">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Your Full Name</label>
                <input type="text" wire:model="owner_name" placeholder="Enter your full name"
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                @error('owner_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Your Email</label>
                <input type="email" wire:model="owner_email" placeholder="you@example.com"
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                @error('owner_email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" x-model="password"
                        placeholder="At least 8 characters"
                        class="w-full rounded-lg border border-slate-300 pl-4 pr-11 py-2.5 text-sm focus:ring-2 focus:ring-sg-sky focus:border-sg-sky">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.781-1.781zm4.261 4.26l1.514 1.515a2 2 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                clip-rule="evenodd" />
                            <path
                                d="M2.458 10c.907 1.984 2.633 3.657 4.717 4.717l-1.98-1.981A5.019 5.019 0 013.958 10c.363-.798.875-1.516 1.502-2.113l1.427 1.427c-.114.278-.173.581-.173.898a5 5 0 006.928 4.622l1.44 1.44A9.958 9.958 0 0110 17c-4.478 0-8.268-2.943-9.542-7 .34-1.084.87-2.083 1.556-2.965l.444.444z" />
                        </svg>
                    </button>
                </div>
                @error('owner_password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                <div class="relative">
                    <input :type="showConfirm ? 'text' : 'password'" x-model="confirm"
                        placeholder="Re-enter your password"
                        :class="matchState === 'mismatch' ? 'border-red-400 focus:ring-red-300 focus:border-red-400' : (
                            matchState === 'match' ?
                            'border-green-400 focus:ring-green-300 focus:border-green-400' :
                            'border-slate-300 focus:ring-sg-sky focus:border-sg-sky')"
                        class="w-full rounded-lg border pl-4 pr-11 py-2.5 text-sm">
                    <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                        <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.781-1.781zm4.261 4.26l1.514 1.515a2 2 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                clip-rule="evenodd" />
                            <path
                                d="M2.458 10c.907 1.984 2.633 3.657 4.717 4.717l-1.98-1.981A5.019 5.019 0 013.958 10c.363-.798.875-1.516 1.502-2.113l1.427 1.427c-.114.278-.173.581-.173.898a5 5 0 006.928 4.622l1.44 1.44A9.958 9.958 0 0110 17c-4.478 0-8.268-2.943-9.542-7 .34-1.084.87-2.083 1.556-2.965l.444.444z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs mt-1.5 flex items-center gap-1.5" x-show="matchState">
                    <template x-if="matchState === 'match'">
                        <span class="text-green-600 flex items-center gap-1"><i class="fas fa-check-circle"></i>
                            Passwords match</span>
                    </template>
                    <template x-if="matchState === 'mismatch'">
                        <span class="text-red-600 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i>
                            Passwords do not match</span>
                    </template>
                </p>
            </div>

            <div class="pt-4 flex justify-between">
                <button wire:click="previousStep" type="button"
                    class="text-sm font-medium text-slate-500 hover:text-slate-700 px-4 py-3">
                    Back
                </button>
                <button wire:click="nextStep" type="button" wire:loading.attr="disabled" wire:target="nextStep"
                    class="bg-gradient-to-r from-sg-primary to-sg-sky text-white font-semibold px-8 py-3 rounded-lg text-sm hover:brightness-105 transition disabled:opacity-70">
                    Continue
                </button>
            </div>
        </div>
    @endif

    {{-- Step 3 — Review & Create --}}
    @if ($step === 3)
        <div class="space-y-6">
            <div class="bg-sg-bg rounded-xl p-5 space-y-3">
                <h3 class="text-sm font-semibold text-sg-primaryDark uppercase tracking-wide">School</h3>
                <dl class="text-sm text-slate-600 space-y-1">
                    <div class="flex justify-between">
                        <dt>Name</dt>
                        <dd class="font-medium text-slate-800">{{ $school_name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Email</dt>
                        <dd class="font-medium text-slate-800">{{ $school_email }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>City / Country</dt>
                        <dd class="font-medium text-slate-800">{{ $city ? $city . ', ' : '' }}{{ $country }}
                        </dd>
                    </div>
                    {{-- ADD THIS --}}
                    @if ($short_name)
                        <div class="flex justify-between">
                            <dt>Short Name</dt>
                            <dd class="font-medium text-slate-800">{{ $short_name }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
            <div class="bg-sg-bg rounded-xl p-5 space-y-3">
                <h3 class="text-sm font-semibold text-sg-primaryDark uppercase tracking-wide">School Owner</h3>
                <dl class="text-sm text-slate-600 space-y-1">
                    <div class="flex justify-between">
                        <dt>Name</dt>
                        <dd class="font-medium text-slate-800">{{ $owner_name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Email</dt>
                        <dd class="font-medium text-slate-800">{{ $owner_email }}</dd>
                    </div>
                </dl>
            </div>

            <p class="text-xs text-slate-400">By creating an account, you'll get a 3-month free trial with full setup
                and training support.</p>

            <div class="pt-2 flex justify-between">
                <button wire:click="previousStep" type="button"
                    class="text-sm font-medium text-slate-500 hover:text-slate-700 px-4 py-3"
                    wire:loading.attr="disabled">
                    Back
                </button>
                <button wire:click="register" type="button"
                    class="bg-gradient-to-r from-sg-primary to-sg-sky text-white font-semibold px-8 py-3 rounded-lg text-sm hover:brightness-105 transition inline-flex items-center gap-2 disabled:opacity-70"
                    wire:loading.attr="disabled" wire:target="register">
                    <span wire:loading.remove wire:target="register">Create School Account</span>
                    <span wire:loading wire:target="register" class="flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin"></i> Creating account...
                    </span>
                </button>
            </div>
        </div>
    @endif

</div>
