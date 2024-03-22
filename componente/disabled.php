<div class="row ">
    <div class="alert alert-danger" role="alert">
        Os pagamentos estão desativados! Tente mais tarde
        <label style="float: right;" class="count">redirecionando em 10s</label>
    </div>
</div>
<script>
    var secont = 10;
    var countdown = setInterval(() => {
        
        $('.alert.alert-danger .count').html('redirecionando em '+secont+'s')
        secont--;

        if (secont < 0) {
            clearInterval(countdown);
            window.location = '../';
        }
    },1000)
</script>