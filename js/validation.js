/* add members  form validation*/
$( "#members" ).validate({
  rules: {
    position:{
      required: true,
    },
    Name:{
      required: true,
      minlength : 6,
      maxlength: 20
    },
    username:{
      required: true,
      minlength : 6,
      maxlength: 20
    },
    email: {
      required: true,
      email:true
    },
    pass: {
      required: true,
      minlength : 6,
    },
    pass_confirm: {
      required: true,
      minlength : 6,
      equalTo : "#password"
    }
  }
});

/* add stock  form validation*/
$( "#stock" ).validate({
  rules: {
    name:{
      required: true,    
       minlength : 2,
      maxlength: 60
    },
    type:{
      required: true,
      minlength : 2,
      maxlength: 60
    },
    Company:{
      required: true,
      minlength : 2,
      maxlength: 60
    },
    quantity:{
      required: true,
    },
    cost: {
      required: true,
    },
    statues: {
      required: true,
    },
  }
});