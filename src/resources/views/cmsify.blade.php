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

@include('cmsify::partials.summernote-script')

<script src="/vendor/cmsify/cmsify_vendor.js"></script>
<script src="/vendor/cmsify/cmsify.js"></script>

</body>


</html>
