<!-- Classic Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 1051">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: transparent;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card my-0">
                        <div class="card-header card-header-danger card-header-text text-center">
                            <div class="card-text">
                                <h4 class="card-title">Sesiunea a expirat.</h4>
                            </div>
                        </div>
                        <div class="card-body px-3 text-center">
                            <h4 class="mt-5 mb-3">Va rugam sa va logati din nou.</h4>
                            <a href="javascript:location.reload()" class="btn btn-success">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  End Modal -->

<script>
    $('#loginModal').modal('show');
</script>