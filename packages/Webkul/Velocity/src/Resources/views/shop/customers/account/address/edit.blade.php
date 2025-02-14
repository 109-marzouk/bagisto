@extends('shop::customers.account.index')

@section('page_title')
    {{ __('shop::app.customer.account.address.edit.page-title') }}
@endsection

@section('page-detail-wrapper')
    <div class="account-head mb-15">
        <span class="account-heading">{{ __('shop::app.customer.account.address.edit.title') }}</span>

        <span></span>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.address.edit.before', ['address' => $address]) !!}

    <form method="post" action="{{ route('customer.address.update', $address->id) }}" @submit.prevent="onSubmit">
        <div class="account-table-content">
            @method('PUT')

            @csrf

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.before', ['address' => $address]) !!}

            <div class="control-group" :class="[errors.has('company_name') ? 'has-error' : '']">
                <label for="company_name">{{ __('shop::app.customer.account.address.edit.company_name') }}</label>

                <input type="text"  class="control" name="company_name" value="{{ old('company_name') ?? $address->company_name }}" data-vv-as="&quot;{{ __('shop::app.customer.account.address.edit.company_name') }}&quot;">

                <span class="control-error" v-if="errors.has('company_name')" v-text="errors.first('company_name')"></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.company_name.after') !!}

            <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                <label for="first_name" class="mandatory">{{ __('shop::app.customer.account.address.create.first_name') }}</label>

                <input type="text" class="control" name="first_name" value="{{ old('first_name') ?? $address->first_name }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.first_name') }}&quot;">

                <span class="control-error" v-if="errors.has('first_name')" v-text="errors.first('first_name')"></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.first_name.after') !!}

            <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                <label for="last_name" class="mandatory">{{ __('shop::app.customer.account.address.create.last_name') }}</label>

                <input type="text" class="control" name="last_name" value="{{ old('last_name') ?? $address->last_name }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.last_name') }}&quot;">

                <span class="control-error" v-if="errors.has('last_name')" v-text="errors.first('last_name')"></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.last_name.after') !!}

            <div class="control-group" :class="[errors.has('vat_id') ? 'has-error' : '']">
                <label for="vat_id">{{ __('shop::app.customer.account.address.create.vat_id') }}
                    <span class="help-note">{{ __('shop::app.customer.account.address.create.vat_help_note') }}</span>
                </label>

                <input type="text" class="control" name="vat_id" value="{{ old('vat_id') ?? $address->vat_id }}" v-validate="" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.vat_id') }}&quot;">

                <span class="control-error" v-if="errors.has('vat_id')" v-text="errors.first('vat_id')"></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.vat_id.after') !!}

            @php
                $addresses = old('address1') ?? explode(PHP_EOL, $address->address1);
            @endphp

            <div class="control-group" :class="[errors.has('address1[]') ? 'has-error' : '']">
                <label for="address_0" class="mandatory">{{ __('shop::app.customer.account.address.edit.street-address') }}</label>

                <input type="text" class="control" name="address1[]" value="{{ isset($addresses[0]) ? $addresses[0] : '' }}" id="address_0" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.street-address') }}&quot;">

                <span class="control-error" v-if="errors.has('address1[]')" v-text="errors.first('address1[]')"></span>
            </div>

            @if (core()->getConfigData('customer.settings.address.street_lines') && core()->getConfigData('customer.settings.address.street_lines') > 1)
                @for ($i = 1; $i < core()->getConfigData('customer.settings.address.street_lines'); $i++)
                    <div class="control-group" style="margin-top: -25px;">
                        <input type="text" class="control" name="address1[{{ $i }}]" id="address_{{ $i }}" value="{{ $addresses[$i] ?? '' }}">
                    </div>
                @endfor
            @endif

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.street-addres.after') !!}

            @include ('shop::customers.account.address.country-state', ['countryCode' => old('country') ?? $address->country, 'stateCode' => old('state') ?? $address->state])

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.country-state.after') !!}

            <div class="control-group" :class="[errors.has('city') ? 'has-error' : '']">
                <label for="city" class="mandatory">{{ __('shop::app.customer.account.address.create.city') }}</label>

                <input type="text" class="control" name="city" value="{{ old('city') ?? $address->city }}" v-validate="'required|regex:^[a-zA-Z \-]*$'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.city') }}&quot;">

                <span class="control-error" v-if="errors.has('city')" v-text="errors.first('city')"></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.create.after') !!}

            <div class="control-group" :class="[errors.has('postcode') ? 'has-error' : '']">
                <label for="postcode" class="mandatory">{{ __('shop::app.customer.account.address.create.postcode') }}</label>

                <input type="text" class="control" name="postcode" value="{{ old('postcode') ?? $address->postcode }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.postcode') }}&quot;">

                <span class="control-error" v-if="errors.has('postcode')" v-text="errors.first('postcode')"></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.postcode.after') !!}

            <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                <label for="phone" class="mandatory">{{ __('shop::app.customer.account.address.create.phone') }}</label>

                <input type="text" class="control" name="phone" value="{{ old('phone') ?? $address->phone }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.phone') }}&quot;">

                <span class="control-error" v-if="errors.has('phone')" v-text="errors.first('phone')"></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.after', ['address' => $address]) !!}

            <div class="control-group d-flex">
                <input type="checkbox" id="default_address" class="w-auto" name="default_address" {{ $address->default_address ? 'checked' : '' }} >

                <label class="checkbox-view" for="default_address"></label>

                {{ __('shop::app.customer.account.address.default-address') }}
            </div>

            <div class="button-group">
                <button class="theme-btn" type="submit">
                    {{ __('shop::app.customer.account.address.create.submit') }}
                </button>
            </div>
        </div>
    </form>

    {!! view_render_event('bagisto.shop.customers.account.address.edit.after', ['address' => $address]) !!}
@endsection