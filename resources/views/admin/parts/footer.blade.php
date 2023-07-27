
    <footer class="main-footer">
        <strong>Контракт &copy; {{ date('Y') }}.</strong>
        Все права защищены.
        <div class="float-right d-none d-sm-inline-block">
            <b>Версия</b> 2.0.0
        </div>
    </footer>

</div>
<!-- ./wrapper -->

@yield('footer_html')


<!-- jQuery -->
<script src="{{ asset("assets/admin/plugins/jquery/jquery.min.js") }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset("assets/admin/plugins/jquery-ui/jquery-ui.min.js") }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset("assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- Summernote -->
<script src="{{ asset("assets/admin/plugins/summernote/summernote-bs4.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("assets/admin/js/adminlte.js") }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset("assets/admin/js/pages/dashboard.js") }}"></script>

<script src="{{ asset("assets/admin/plugins/select2/js/select2.full.min.js") }}"></script>

@yield('custom_script')

<script>
    $('.select-author').select2();
    $('.select-category').select2();
</script>

</body>
</html>