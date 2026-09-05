# Third-Party Notices Draft

Audit date: 2026-09-05

This is an evidence inventory for the copied browser assets in `main_file/public/assets/libs`. It is a draft, not a substitute for the complete license texts. Before distributing the application, add the corresponding upstream license text for every used component and preserve all copyright banners already embedded in minified files.

## Copied library inventory

| Bundled directory | Observed version/evidence | License status in archive |
|---|---|---|
| `@fortawesome/fontawesome-free` | Font Awesome Free 5.8.2 | LICENSE present. Icons: CC BY 4.0; fonts: SIL OFL 1.1; code: MIT. Brand marks may also be trademarks. |
| `animate.css` | Source tree present; exact bundled version not stated in inspected files | Upstream project is MIT, but standalone license is missing here; version and license text must be restored from the matching release. |
| `apexcharts` | Header: ApexCharts 3.6.10, Juned Chhipa | Header declares MIT; standalone license missing. |
| `autosize` | Header: autosize 4.0.2 | Header declares MIT; standalone license missing. |
| `bootstrap` | Header: Bootstrap 4.3.1 | Header declares MIT and retains Bootstrap/Twitter copyrights; standalone license missing. |
| `bootstrap-daterangepicker` | Header: 2.1.30, Dan Grossman | Header declares MIT; standalone license missing. |
| `bootstrap-notify` | Minified distribution only | No version/license banner found in copied file. Resolve against the exact upstream release before redistribution. |
| `bootstrap-tagsinput` | Distribution CSS/JS copied | No reliable version/license banner found in inspected files. Resolve exact upstream release and restore its license. |
| `bootstrap-timepicker` | Joris de Wit/contributors banner | Header states MIT in the JS build, but other files refer to a LICENSE that is absent. Restore it. |
| `clipboard` | Header: clipboard.js 2.0.4, Zeno Rocha | Header declares MIT; standalone license missing. |
| `dragula` | Minified CSS/JS distribution | No reliable version/license banner found in the selected copied build. Resolve exact release and restore license. |
| `dropzone` | Distribution tree copied | License/version banner absent from the inspected minified build. Resolve exact release and restore license. |
| `dropzonejs` | Appears to duplicate a second Dropzone distribution | Treat as a duplicate provenance item until exact version/hash is reconciled; restore matching license or remove the unused duplicate after usage testing. |
| `flatpickr` | Full distribution/plugins/locales tree | Main license file absent; some generated/plugin files contain Microsoft Apache-2.0 notices. Preserve those notices and restore the matching upstream license set. |
| `fullcalendar` | Header: FullCalendar 3.10.0, Adam Shaw | License link/copyright retained; standalone matching license missing. |
| `highlight.js` | Large language-module tree | Exact version/license file missing from this copied directory. Resolve the bundled release and restore its BSD license and copyright notice. |
| `jquery` | jQuery distribution/source fragments | Exact banner was not present in the sampled smallest file; standalone license missing. Resolve exact release and restore MIT license. |
| `jquery-ui` | jQuery UI distribution | LICENSE present, including the applicable MIT terms and CC0 sample-code statement. |
| `moment` | Moment distribution/locales tree | Standalone license/version evidence missing from the copied directory. Resolve exact release and restore MIT license. |
| `nicescroll` | Header: jquery.nicescroll 3.7.6, InuYaksa | Header declares MIT; standalone license missing. |
| `progressbar.js` | Header: ProgressBar.js 1.0.1 | Header declares MIT; standalone license missing. |
| `select2` | Header: Select2 4.0.7-rc.0 | Header links to upstream license; standalone license missing. |
| `summernote` | Distribution/plugin/language tree | Exact version/license evidence missing from the copied directory. Resolve exact release and restore its license. |
| `swiper` | Header: Swiper 4.5.0, Vladimir Kharlampidi | Header declares MIT; standalone license missing. |
| `@fancyapps` | Directory now empty | Unused fancyBox 3.5.7 JS/CSS were removed because their header required GPLv3 open-source compliance or a commercial license. Remove the empty directory manually if desired. |

## Commercial design asset requiring separate proof

The table above does not cover the Webpixels **Purpose Application UI Kit**. It is a paid design product, not an ordinary permissive JavaScript dependency. Its copyright banner occurs in:

- `main_file/public/assets/css/purpose-blue-light.css`
- `main_file/public/assets/css/purpose-blue-dark.css`

The live application also uses compiled Purpose-derived styling and ships the related premium icon collection. Keep the seller's redistribution authorization and the license tier covering the actual deployment. If that evidence cannot be obtained, replace the Purpose-derived CSS, icons, illustrations, and premium plugins.

## Release gate

Do not rename this file to a final `THIRD_PARTY_NOTICES` declaration until:

1. every actively shipped copied component has an exact name and version;
2. its full matching license text is bundled;
3. duplicate/unreferenced distributions are removed after regression testing;
4. Webpixels Purpose redistribution/deployment permission is documented; and
5. stock/demo images and customer-provided logos have a separate provenance register.
