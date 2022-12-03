
<ul class="footer-social">
    @if ($settings->facebook !== null)
        <li><a href="{{ $settings->facebook }}" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a></li>
    @endif
    @if ($settings->twitter !== null)
        <li><a href="{{ $settings->twitter }}" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a></li>
    @endif
    @if ($settings->instagram !== null)
        <li><a href="{{ $settings->instagram }}" target="_blank" class="instagram"><i class="fa fa-instagram"></i></a></li>
    @endif
    @if ($settings->youtube !== null)
        <li><a href="{{ $settings->youtube }}" target="_blank" class="youtube"><i class="fa fa-youtube"></i></a></li>
    @endif
    @if ($settings->linkedin !== null)
        <li><a href="{{ $settings->linkedin }}" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
    @endif
</ul>
