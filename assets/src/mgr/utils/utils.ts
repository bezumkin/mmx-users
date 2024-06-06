export function formatDate(val: string | null): string {
  if (!val) {
    return ''
  }
  const date = new Date(val)
  return date.toLocaleDateString() + ' ' + date.toLocaleTimeString()
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
