// @ts-ignore
const MODx = window.MODx || {config: {}}
const namespace = getNamespace()

const defaultSettings: Record<string, string> = {
  'group-tabs-create': 'main,users',
  'group-tabs-edit': 'main,users',
  'group-grid-columns': `{"id":{"sortable":true},"name":{"sortable":true},"parent.name":{"sortable":false},"members_count":{"sortable":true},"rank":{"sortable":true}}`,
  'user-tabs-create': 'main,extended,groups',
  'user-tabs-edit': 'general,extended,groups,settings,commerce-addresses',
  'user-grid-columns': `{"id":{"sortable":true},"username":{"sortable":true},"fullname":{"sortable":true},"email":{"sortable":true}}`,
  'user-form-fields-available': `{"username":{"type":"text","required":true},"email":{"type":"email","required":true},"fullname":{"type":"email"},"dob":{"type":"date"},"gender":{"type":"gender"},"website":{"type":"url"},"phone":{"type":"tel"},"mobilephone":{"type":"tel"},"fax":{"type":"tel"},"country":{"type":"country"},"state":{"type":"text"},"city":{"type":"text"},"zip":{"type":"text"},"address":{"type":"textarea"},"active":{"type":"checkbox"},"blocked":{"type":"checkbox"},"sudo":{"type":"checkbox"},"extended.pay_afterwards":{"type":"checkbox","default":false},"settings.twofactoroptions":{"type":"checkbox","default":false},"extended.main_branch":{"type":"select","options":["","Drachten","Leeuwarden"]},"extended.max_days_order_overview":{"type":"number","default":60},"comment":{"type":"text","required":true},"photo":{"type":"image"},"extended.company_logo":{"type":"image"},"password":{"type":"user-password"}}`,
  'user-form-fields-sudo': `[["username","fullname",["phone","mobilephone"],"fax","country",["state","city","zip"],"address"],["email",["dob","gender"],"website",["active","blocked"],"sudo","comment","photo","password"]]`,
  'user-form-fields-user': `[["username","fullname",["phone","mobilephone"],"fax","country",["state","city","zip"],"address"],["email",["dob","gender"],"website",["active","blocked"],"comment","photo","password"]]`,
}

export function formatDate(val: string | null): string {
  if (!val) {
    return ''
  }
  const date = new Date(val)
  return date.toLocaleDateString() + ' ' + date.toLocaleTimeString()
}

export function setDeepValue(obj: Record<string, any>, value: any, propPath: string) {
  const [head, ...rest] = propPath.split('.')
  if (obj[head] === undefined) {
    obj[head] = {}
  }
  !rest.length ? (obj[head] = value) : setDeepValue(obj[head], value, rest.join('.'))
}

export function getCommerceAddressTypes(addAny: Boolean = false) {
  const items = [
    {text: $t('models.commerce.address.types.shipping'), value: 'shipping'},
    {text: $t('models.commerce.address.types.billing'), value: 'billing'},
  ]

  if (addAny) {
    items.unshift({text: $t('models.commerce.address.types.any'), value: ''})
  }

  return items
}

export function getSystemSetting(key: string) {
  if (!key.startsWith(namespace)) {
    key = namespace + '.' + key
  }
  let value = MODx.config[key]
  if (value !== undefined) {
    value = value.trim()
  }
  if (!value) {
    value = defaultSettings[key.replace(namespace + '.', '')]
  }
  if (!value) {
    return null
  }
  if (value[0] === '{' || value[0] === '[') {
    value = JSON.parse(value)
  }
  return value
}

export function getSettingTypes() {
  return [
    'textfield',
    'textarea',
    'numberfield',
    'combo-boolean',
    'text-password',
    'modx-combo-category',
    'modx-combo-charset',
    'modx-combo-country',
    'modx-combo-context',
    'modx-combo-namespace',
    'modx-combo-template',
    'modx-combo-user',
    'modx-combo-usergroup',
    'modx-combo-language',
    'modx-combo-source',
    'modx-combo-source-type',
    'modx-combo-manager-theme',
    'modx-grid-json',
  ]
}
