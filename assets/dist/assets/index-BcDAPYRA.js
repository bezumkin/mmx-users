import{B as C,Q as N}from"./vesp-3mqwPoPx.js";import{_ as R}from"./user-group.vue_vue_type_script_setup_true_lang-DVsCRd5n.js";import{w as S,g as F}from"./vue-bootstrap-DqOMAocd.js";import{d as E,z as f,A as U,ac as $,g as z,o as m,b as g,w as l,q as c,c as A,F as D,p as I,u as a,e as M,f as Q,i as q,X as G,a6 as v,Y as H,m as K}from"./vue-COS8aM9k.js";import{a as L,u as P}from"./vue-router-a3flUsTq.js";import{c as T,E as X}from"./api-C4uRSHIu.js";import{g as Y}from"./mgr-BP96vxn6.js";const j={class:"mt-3"},ae=E({__name:"index",async setup(J){let n,p;const d=L(),w=P(),r=Number(d.params.id),t=f({id:0,name:"",description:"",active:!0,aw_parallel:!1,aw_contexts:[]}),s=f(""),_=U(()=>({url:"mgr/user-groups"+(r?"/"+r:""),title:T("models.user_group.title_one")+(r?": "+t.value.name:""),updateKey:"mgr-user-groups",method:r?"patch":"put",size:s.value?"lg":"md",hideFooter:s.value!=="",onHidden(){w.push({name:"groups"})}}));if(r)try{t.value=([n,p]=$(()=>X(_.value.url)),n=await n,p(),n)}catch(o){console.error(o),C()}const i=Y(r?"group-tabs-edit":"group-tabs-create").split(",").map(o=>o.trim());return i.forEach(o=>{String(d.name).includes(o)&&(s.value=o)}),i.includes("main")||i.unshift("main"),(o,u)=>{const V=S,h=F,b=R,x=z("RouterView"),B=N;return m(),g(B,K({modelValue:a(t),"onUpdate:modelValue":u[1]||(u[1]=e=>v(t)?t.value=e:null)},a(_)),{"form-fields":l(()=>[c(h,{tabs:""},{default:l(()=>[(m(!0),A(D,null,I(a(i),e=>(m(),g(V,{key:e,to:{name:e==="main"?"groups-id":"groups-id-index-"+e,params:{id:a(t).id}},active:e==="main"?!a(s):a(s)===e,"active-class":"",onClick:O=>s.value=e==="main"?"":e},{default:l(()=>[M(Q(o.$t("models.user_group.tabs."+e+".title")),1)]),_:2},1032,["to","active","onClick"]))),128))]),_:1}),q("div",j,[G(c(b,{modelValue:a(t),"onUpdate:modelValue":u[0]||(u[0]=e=>v(t)?t.value=e:null)},null,8,["modelValue"]),[[H,!a(s)]]),c(x)])]),_:1},16,["modelValue"])}}});export{ae as default};