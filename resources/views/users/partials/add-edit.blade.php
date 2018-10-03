@csrf
<div class="form-group">
    <label for="inputFullname">Name</label>
    <input
            type="text" class="form-control"
            name="name" disabled id="inputFullname"
            placeholder="Name" value="{{old('name', $user->name) }}"/>
</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input
            type="email" class="form-control"
            name="email" disabled id="inputEmail"
            placeholder="Email address" value="{{old('email', $user->email) }}"/>
</div>
<div class="form-group">
    <label for="inputType">Type</label>
    <select name="type" id="inputType" class="form-control">
        <option disabled selected> -- select an option --</option>
        <option value="0">Client</option>
        <option value="1">Administrator</option>
    </select>
</div>


