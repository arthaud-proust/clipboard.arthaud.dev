import{d as f,u as w,S as _,g as V,w as p,o as g,a as o,e as s,i as b,b as r,f as k,t as v,n as y,j as x}from"./app-u_f2ncIN.js";import{_ as l,a as i,b as m}from"./TextInput.vue_vue_type_script_setup_true_lang-chsLiDOZ.js";import{P}from"./PrimaryButton-BNgxZAPp.js";import{_ as B}from"./GuestLayout.vue_vue_type_script_setup_true_lang-Bd6TLFUk.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const C={class:"mt-4"},$={class:"mt-4"},q={class:"mt-4 flex items-center justify-end"},D=f({__name:"ResetPassword",props:{email:{},token:{}},setup(u){const n=u,{t:d}=w(),e=_({token:n.token,email:n.email,password:"",password_confirmation:""}),c=()=>{e.post(route("password.store"),{onFinish:()=>{e.reset("password","password_confirmation")}})};return(N,a)=>(g(),V(B,null,{default:p(()=>[o(s(b),{title:s(d)("reset_password")},null,8,["title"]),r("form",{onSubmit:x(c,["prevent"])},[r("div",null,[o(l,{for:"email",value:"Email"}),o(i,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":a[0]||(a[0]=t=>s(e).email=t),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),o(m,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),r("div",C,[o(l,{for:"password",value:"Password"}),o(i,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":a[1]||(a[1]=t=>s(e).password=t),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(m,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),r("div",$,[o(l,{for:"password_confirmation",value:"Confirm Password"}),o(i,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:s(e).password_confirmation,"onUpdate:modelValue":a[2]||(a[2]=t=>s(e).password_confirmation=t),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(m,{class:"mt-2",message:s(e).errors.password_confirmation},null,8,["message"])]),r("div",q,[o(P,{class:y({"opacity-25":s(e).processing}),disabled:s(e).processing},{default:p(()=>[k(v(s(d)("reset_password")),1)]),_:1},8,["class","disabled"])])],32)]),_:1}))}});export{D as default};
