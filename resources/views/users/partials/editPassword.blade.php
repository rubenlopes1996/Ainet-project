@csrf
<div class="form-group">
    <label for="inputPassword">Password</label>
    <input
            type="password" class="form-control"
            name="password" id="inputPassword"
    />
</div>
<div class="form-group">
    <label for="inputPasswordConfirmation">Password confirmation</label>
    <input
            type="password" class="form-control"
            name="password_confirmation" id="inputPasswordConfirmation"/>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" name="ok">Add</button>
    <a class="btn btn-default" href="{{route('users.index')}}">Cancel</a>
</div>
