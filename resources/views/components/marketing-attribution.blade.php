@php
    $attributionDefaults = [
        'utm_source' => request()->query('utm_source', ''),
        'utm_medium' => request()->query('utm_medium', ''),
        'utm_campaign' => request()->query('utm_campaign', ''),
        'utm_content' => request()->query('utm_content', ''),
        'utm_term' => request()->query('utm_term', ''),
        'acquisition_referrer' => request()->query('acquisition_referrer', ''),
        'acquisition_landing_path' => request()->query('acquisition_landing_path', ''),
        'acquisition_source_page' => request()->query('acquisition_source_page', request()->query('whv_source_page', '')),
        'acquisition_variant' => request()->query('acquisition_variant', request()->query('whv_variant', '')),
        'acquisition_last_cta' => request()->query('acquisition_last_cta', ''),
    ];
@endphp

@foreach($attributionDefaults as $field => $defaultValue)
    <input type="hidden" name="{{ $field }}" value="{{ old($field, $defaultValue) }}" data-attribution-field="{{ $field }}">
@endforeach

<script>
(() => {
    const queryParams = new URLSearchParams(window.location.search);
    let storedAttribution = {};

    try {
        storedAttribution = JSON.parse(
            window.sessionStorage.getItem('marketing_attribution_context')
            || window.sessionStorage.getItem('whv_attribution_context')
            || window.localStorage.getItem('marketing_attribution_context')
            || window.localStorage.getItem('whv_attribution_context')
            || '{}'
        );
    } catch (error) {
        storedAttribution = {};
    }

    const normalizedAttribution = {
        utm_source: queryParams.get('utm_source') || storedAttribution.utm_source || '',
        utm_medium: queryParams.get('utm_medium') || storedAttribution.utm_medium || '',
        utm_campaign: queryParams.get('utm_campaign') || storedAttribution.utm_campaign || '',
        utm_content: queryParams.get('utm_content') || storedAttribution.utm_content || '',
        utm_term: queryParams.get('utm_term') || storedAttribution.utm_term || '',
        acquisition_referrer: queryParams.get('acquisition_referrer') || storedAttribution.acquisition_referrer || storedAttribution.referrer || document.referrer || '',
        acquisition_landing_path: queryParams.get('acquisition_landing_path') || storedAttribution.acquisition_landing_path || storedAttribution.landing_path || window.location.pathname || '',
        acquisition_source_page: queryParams.get('acquisition_source_page') || queryParams.get('whv_source_page') || storedAttribution.acquisition_source_page || '',
        acquisition_variant: queryParams.get('acquisition_variant') || queryParams.get('whv_variant') || storedAttribution.acquisition_variant || '',
        acquisition_last_cta: queryParams.get('acquisition_last_cta') || storedAttribution.acquisition_last_cta || window.sessionStorage.getItem('marketing_last_cta') || window.localStorage.getItem('marketing_last_cta') || '',
    };

    document.querySelectorAll('[data-attribution-field]').forEach((field) => {
        const fieldName = field.getAttribute('data-attribution-field');
        const nextValue = normalizedAttribution[fieldName] || '';
        if (!field.value && nextValue) {
            field.value = nextValue;
        }
    });

    try {
        const serialized = JSON.stringify(normalizedAttribution);
        window.sessionStorage.setItem('marketing_attribution_context', serialized);
        window.localStorage.setItem('marketing_attribution_context', serialized);
    } catch (error) {
        // Ignore storage errors in restricted contexts.
    }
})();
</script>