@php
$lang = Session::get('locale');
@endphp

@if($lang == 'cs')
<a href="{{ route('changeLocale', ['locale' => 'en']) }}">
    <span
        src="{{ asset('img/flags/en.svg') }}"
        alt="{{ __('Language switch') }}"
        title="{{ __('Switch to :language.', ['language' => 'English']) }}"
        aria-title="{{ __('Switch to :language.', ['language' => 'English']) }}"
        class="img--locale img__en">
    </span>
</a>
@else
<a href="{{ route('changeLocale', ['locale' => 'cs']) }}">
    <span
        src="{{ asset('storageimg/flags/cs.svg') }}"
        alt="{{ __('Language switch') }}"
        title="{{ __('Switch to :language.', ['language' => 'češtiny']) }}"
        aria-title="{{ __('Switch to :language.', ['language' => 'češtiny']) }}"
        class="img--locale img__cs">
    </span>
</a>
@endif
