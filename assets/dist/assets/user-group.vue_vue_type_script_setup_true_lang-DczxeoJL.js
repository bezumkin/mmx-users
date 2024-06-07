import{$ as E,k as L,o as j,v as D,L as I,e as R,f as S}from"./vue-bootstrap-BvSPrray.js";import{d as h}from"./vesp-D0Z_8SFv.js";import{d as z,A as g,z as A,B as G,o as s,c as d,q as r,w as n,u as o,e as v,f as c,b as _,X as H,i as k,ab as O,m as P,j as X,h as m,F as J,p as K}from"./vue-COS8aM9k.js";import{E as Q}from"./api-onBQ7tug.js";const W={disabled:"",value:""},Y={key:1,class:"d-flex my-2 gap-1"},ae=z({__name:"user-group",props:{modelValue:{type:Object,required:!0}},emits:["update:modelValue"],setup(b,{emit:y}){const w=b,x=y,t=g({get(){return w.modelValue},set(a){x("update:modelValue",a)}}),p=A([]),f=g(()=>p.value.filter(a=>!t.value.aw_contexts.includes(a.value)));return G(async()=>{try{(await Q("mgr/contexts",{combo:!0,sort:"rank"})).rows.forEach(e=>{e.key!=="mgr"&&(p.value.push({text:e.name,value:e.key}),t.value.aw_contexts.push(e.key))})}catch{}}),(a,e)=>{const V=E,u=L,B=j,$=h,F=D,C=I,U=R,T=S;return s(),d("div",null,[r(u,{label:a.$t("models.user_group.name")},{default:n(()=>[r(V,{modelValue:o(t).name,"onUpdate:modelValue":e[0]||(e[0]=l=>o(t).name=l),required:""},null,8,["modelValue"])]),_:1},8,["label"]),r(u,{label:a.$t("models.user_group.description")},{default:n(()=>[r(B,{modelValue:o(t).description,"onUpdate:modelValue":e[1]||(e[1]=l=>o(t).description=l),rows:"3"},null,8,["modelValue"])]),_:1},8,["label"]),r(u,{label:a.$t("models.user_group.parent")},{default:n(()=>[r($,{modelValue:o(t).parent,"onUpdate:modelValue":e[2]||(e[2]=l=>o(t).parent=l),url:"mgr/user-groups","text-field":"name",sort:"name","filter-props":{exclude:o(t).id}},null,8,["modelValue","filter-props"])]),_:1},8,["label"]),r(u,{label:a.$t("models.user_group.rank")},{default:n(()=>[r(V,{modelValue:o(t).rank,"onUpdate:modelValue":e[3]||(e[3]=l=>o(t).rank=l),modelModifiers:{number:!0}},null,8,["modelValue"])]),_:1},8,["label"]),r(u,null,{default:n(()=>[r(F,{modelValue:o(t).aw_parallel,"onUpdate:modelValue":e[4]||(e[4]=l=>o(t).aw_parallel=l)},{default:n(()=>[v(c(a.$t("models.user_group.resource_group.create")),1)]),_:1},8,["modelValue"])]),_:1}),o(t).aw_parallel?(s(),_(u,{key:0,description:a.$t("models.user_group.resource_group.desc")},{default:n(()=>[H(k("input",{"onUpdate:modelValue":e[5]||(e[5]=l=>o(t).aw_contexts=l),style:{display:"none"},required:""},null,512),[[O,o(t).aw_contexts]]),o(p).length?(s(),_(T,{key:0,modelValue:o(t).aw_contexts,"onUpdate:modelValue":e[6]||(e[6]=l=>o(t).aw_contexts=l),"add-on-change":"","no-outer-focus":""},{default:n(({tags:l,inputAttrs:q,inputHandlers:M,removeTag:N})=>[o(f).length>0?(s(),_(C,P({key:0},q,{options:o(f)},X(M)),{first:n(()=>[k("option",W,c(a.$t("models.user_group.resource_group.select")),1)]),_:2},1040,["options"])):m("",!0),l.length>0?(s(),d("div",Y,[(s(!0),d(J,null,K(l,i=>(s(),d("div",{key:i},[r(U,{variant:"info",onRemove:Z=>N(i)},{default:n(()=>[v(c(i),1)]),_:2},1032,["onRemove"])]))),128))])):m("",!0)]),_:1},8,["modelValue"])):m("",!0)]),_:1},8,["description"])):m("",!0)])}}});export{ae as _};