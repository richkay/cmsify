<!DOCTYPE html>
<html>
<head>
    <title>CMSIFY</title>
    <link rel="stylesheet" href="/css/cmsify.css">
    <link rel="stylesheet" href="/css/cmsify_vendor.css">
</head>
<body>

BACKLINK

<input type="hidden" id="token" value="{{ csrf_token() }}">

<div id="cmsify">

    <router-view></router-view>

</div>

@include('cmsify::partials.summernote-script')

<script src="/js/cmsify_vendor.js"></script>
<script src="/js/cmsify.js"></script>

</body>


</html>
