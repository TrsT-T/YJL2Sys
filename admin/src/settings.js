/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 15:33:57
 * @LastEditTime: 2022-07-05 16:50:53
 * @Description: 
 */
module.exports = {
    title: '远境L2系统',

    /**
     * @type {boolean} true | false
     * @description Whether show the settings right-panel
     */
    showSettings: false,

    /**
     * @type {boolean} true | false
     * @description Whether need tagsView
     */
    tagsView: true,

    /**
     * @type {boolean} true | false
     * @description Whether fix the header
     */
    fixedHeader: true,

    /**
     * @type {boolean} true | false
     * @description Whether show the logo in sidebar
     */
    sidebarLogo: true,

    /**
     * @type {boolean} true | false
     * @description Whether support pinyin search in headerSearch
     * Bundle size minified 47.3kb,minified + gzipped 63kb
     */
    supportPinyinSearch: true,

    /**
     * @type {string | array} 'production' | ['production', 'development']
     * @description Need show err logs component.
     * The default is only used in the production env
     * If you want to also use it in dev, you can pass ['production', 'development']
     */
    errorLog: 'production'
}