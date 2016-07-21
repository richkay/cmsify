<!DOCTYPE html>
<html>
<head>
    <title>CMSIFY</title>
    <link rel="stylesheet" href="/vendor/cmsify/cmsify.css">
    <link rel="stylesheet" href="/vendor/cmsify/cmsify_vendor.css">

</head>
<body>

BACKLINK

<input type="hidden" id="token" value="{{ csrf_token() }}">

<div id="cmsify">

    <router-view></router-view>

</div>

{{--use laravel config here and @include(package::) this, package consumer can override this --}}
<script type="text/javascript">
    function initSummernote()
    {
        return $('.Summernote').summernote({
            height: 100,
        });
    }
</script>

<script src="/vendor/cmsify/cmsify_vendor.js"></script>
<script src="/vendor/cmsify/cmsify.js"></script>

</body>


</html>
