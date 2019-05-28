<!-- Request Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Make Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="request_form" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="timein">Timein : </label>
                    <input id="timein" placeholder="Timein" class="form-control" name="timein"
                           type="time">
                    <span class="help-block timein_error"></span>
                </div>
                <div class="form-group">
                    <label for="timein_date">Timein Date : </label>
                    <input id="timein_date" placeholder="Timein Date"
                           class="form-control" name="timein_date"
                           type="date">
                    <span class="help-block timein_date_error"></span>
                </div>
                <div class="form-group">
                    <label for="timein">Timeout : </label>
                    <input id="timeout" placeholder="Timeout"
                           class="form-control {{$errors->has('timeout')?'invalid':''}}" name="timeout"
                           type="time">
                    <span class="help-block timeout_error"></span>
                </div>
                <div class="form-group">
                    <label for="timeout_date">Timeout Date : </label>
                    <input id="timeout_date" placeholder="Timein Date"
                           class="form-control {{$errors->has('timeout_date')?'invalid':''}}" name="timeout_date"
                           type="date">
                    <span class="help-block timeout_error"></span>
                </div>
                <div class="form-group">
                    <label for="message">Message : </label>
                    <textarea id="message" placeholder="Your Message."
                              class="form-control" name="message"
                              type="text"></textarea>
                    <span class="help-block message_error"></span>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="requestSubmit" type="submit" class="btn btn-outline-primary">Send Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>