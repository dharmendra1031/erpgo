<script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
<script >
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher("<?php echo e(config('chatify.pusher.key')); ?>", {
    encrypted: true,
    cluster: "<?php echo e(config('chatify.pusher.options.cluster')); ?>",
    authEndpoint: '<?php echo e(route("pusher.auth")); ?>',
    auth: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
  });
</script>
<script src="<?php echo e(asset('js/chatify/code.js')); ?>"></script>
<script>
  // Messenger global variable - 0 by default
  messenger = "<?php echo e(@$id); ?>";
</script>
<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/vendor/Chatify/layouts/footerLinks.blade.php ENDPATH**/ ?>