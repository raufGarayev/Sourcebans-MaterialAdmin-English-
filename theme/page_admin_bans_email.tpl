<div class="card">
  <div class="card-header">
    <h2>Send E-Mail
      <small>
        SteamID of Player: <b>{$email_addr}</b>
      </small>
    </h2>
  </div>  
  <div class="card-body card-padding p-b-0">
    <div class="form-group m-b-5">
      <label for="theme" class="col-sm-3 control-label">{help_icon title="Subject" message="Type supject of message."} Тема</label>
      <div class="col-sm-9">
        <div class="fg-line">
          <textarea class="form-control p-t-5 textbox" id="subject" name="subject" placeholder="Name of subject.">{$comment}</textarea>
        </div>
        <div id="subject.msg" class="badentry"></div>
      </div>
    </div>
    <div class="form-group m-b-5">
      <label for="message" class="col-sm-3 control-label">{help_icon title="Message" message="Type message."} Message</label>
      <div class="col-sm-9">
        <div class="fg-line">
          <textarea class="form-control p-t-5 textbox" rows="3" id="message" name="message" placeholder="Type your message.">{$comment}</textarea>
        </div>
        <div id="message.msg" class="badentry"></div>
      </div>
    </div>
  </div>
  <div class="card-body card-padding text-center" style="margin-top: 10%;">
    {sb_button text="Send E-Mail" onclick="$email_js" icon="<i class='zmdi zmdi-check-all'></i>" class="ok btn bgm-green btn-icon-text waves-effect" id="aemail" submit=false}
    &nbsp;
    {sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="cancel bgm-red btn-icon-text" id="back" submit=false}
  </div>
</div>