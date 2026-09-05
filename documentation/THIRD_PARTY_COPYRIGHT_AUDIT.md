# Third-Party and Copyright Audit

Audit date: 2026-09-05

## Scope and method

This audit covers the complete supplied workspace and separates four questions that are often incorrectly mixed together:

1. whether the buyer has a valid commercial license for ERPGo;
2. whether bundled third-party components have identifiable licenses;
3. whether required copyright/license notices have been retained; and
4. whether the archive contains common nulled, activation-bypass, obfuscated, or backdoor patterns.

The repository inventory contains 18,186 files after excluding volatile Laravel log/session data. The principal file counts are 12,797 PHP, 2,129 SVG, 834 JavaScript, 207 CSS, 159 text, 75 Vue, 37 SCSS, 237 PNG, 28 JPG, and 82 web/desktop font files. Searches covered application source, routes, configuration, migrations, views, public assets, Composer metadata, package-lock metadata, embedded source headers, URLs, and executable-code primitives.

An automated scan is exhaustive for the defined patterns and files, but it is not a legal opinion and cannot establish authorship from source code alone. Images cannot be cleared by text scanning; their provenance must come from the original author's asset manifest or purchase records.

## Executive conclusion

Status: **not ready to claim fully copyright-cleared**.

- No obvious first-party PHP nulled loader, Envato activation bypass, ionCube payload, encoded executable payload, or web shell was found.
- One unused dual-licensed commercial component, fancyBox 3.5.7, was found. Its own header permits GPLv3 open-source use or requires a fancyBox commercial license for commercial use. No include or invocation existed in the application, so its two unused distribution files were removed.
- A material unresolved commercial dependency remains: the main compiled UI CSS identifies itself as Webpixels' premium **Purpose - Application UI Kit**, copyright 2013-2019 Webpixels. The application actively loads compiled/derived `site*.css` assets from this design system and ships its large icon set. A separate Purpose license or written proof that ERPGo's author was allowed to redistribute these assets is required.
- Composer metadata is substantially complete: 120 production packages, all with declared license metadata.
- The old NPM lockfile itself omits license fields. An isolated `npm ci --ignore-scripts` reconciliation fetched registry metadata and produced 811 installed package instances representing 761 unique name/version combinations. All 761 reported a license and none lacked both metadata and a license file.
- Most copied frontend library directories do not include a standalone license file. Some retain license/copyright headers, but a consolidated third-party notices file and verified package inventory are still required before redistribution.
- Bundled stock/demo images have no embedded license manifest. They should not be assumed cleared for a public production brand merely because they came inside the download.

## ERPGo distribution note

ERPGo is a CodeCanyon commercial item. The application contains SaaS plans and payment gateways.

Practical classification:

- Charging companies/users for access to ERPGo features or subscription plans: obtain/verify an Extended License.
- Reselling the source, sharing the original item, using it for multiple client deployments, or publishing it as a competing stock/template item: not permitted by the normal single-end-product license.
- Rebranding does not transfer ownership of the original item and does not remove third-party attribution obligations.

Evidence missing from this workspace:

- license type (Regular or Extended);
- asset manifest for demo photography/illustrations;
- proof of commercial rights for any customer-supplied replacement branding.

## Composer dependency review

`composer.lock` contains 120 production packages and no package with missing license metadata.

Declared-license distribution:

| Declared license | Packages |
|---|---:|
| MIT | 104 |
| BSD-3-Clause | 6 |
| BSD-2-Clause | 3 |
| BSD/GPL multi-license | 2 |
| Apache-2.0 | 2 |
| LGPL-2.1-or-later | 1 |
| LGPL-3.0 | 1 |
| ISC | 1 |

Packages needing special notice/redistribution attention:

- `ezyang/htmlpurifier` 4.13.0 — LGPL-2.1-or-later; upstream LICENSE is present.
- `milon/barcode` 8.0.1 — LGPL-3.0; upstream LICENSE.TXT is present.
- `nette/schema` 1.2.1 — BSD-3-Clause/GPL multi-license; upstream license.md is present.
- `nette/utils` 3.2.5 — BSD-3-Clause/GPL multi-license; upstream license.md is present.

The presence of an LGPL package is not automatically a violation. Preserve its license/source notices, do not misrepresent authorship, and review obligations before distributing a modified library or a packaged desktop executable.

## Frontend dependency review

`package-lock.json` is lockfile version 1 and its stored dependency records lack `license` properties. To close that evidence gap without modifying the application, the package files were copied to an isolated temporary directory and installed with lifecycle scripts disabled (`npm ci --ignore-scripts --no-audit --no-fund`). NPM installed 811 package instances; scanning installed package manifests produced 761 unique name/version pairs. All 761 declared license metadata, and no package lacked both metadata and a license file.

Resolved-license distribution:

| Declared license | Unique packages |
|---|---:|
| MIT | 664 |
| ISC | 44 |
| BSD-2-Clause | 23 |
| BSD-3-Clause | 11 |
| Apache-2.0 | 9 |
| BSD-3-Clause OR GPL-2.0 | 2 |
| Unlicense | 2 |
| MIT AND BSD-3-Clause | 1 |
| 0BSD | 1 |
| MIT OR CC0-1.0 | 1 |
| CC0-1.0 | 1 |
| CC-BY-4.0 | 1 |
| MIT AND Zlib | 1 |

Focused review items:

- `caniuse-lite` 1.0.30001251 declares CC-BY-4.0 and includes a license file; retain attribution/license material when redistributing its database.
- `node-forge` 0.10.0 and `node-forge-flash` 0.0.0 declare `(BSD-3-Clause OR GPL-2.0)`. Use/document the permissive BSD-3-Clause option rather than treating GPL as mandatory.
- `fs-monkey` 1.0.3 and `memfs` 3.2.2 declare the Unlicense and include license files.
- No AGPL, proprietary, `SEE LICENSE`, or unknown-license NPM package was reported by the installed manifests.

Direct development dependencies declared in `package.json` are Tailwind Forms, Tailwind Typography, Alpine.js, Autoprefixer, Axios, Laravel Mix, Lodash, PostCSS, PostCSS Import, and Tailwind CSS. These dependencies are build-time packages, but their notices and the licenses of code copied into production bundles still need an SBOM generated from a clean install.

Required maintenance before redistribution:

1. preserve the resolved package/license inventory with each release build;
2. retain attribution and license material for production bundles;
3. repeat the reconciliation whenever the lockfile changes; and
4. upgrade/re-lock old vulnerable dependencies only after regression testing.

## Copied public libraries

The `public/assets/libs` tree contains 25 top-level library groups. Only the Font Awesome Free and jQuery UI groups contain clearly named standalone license files. License headers identify many others, including Bootstrap, Dropzone, Select2, ApexCharts, Autosize, Clipboard.js, Moment, Swiper, Owl Carousel, and installer Font Awesome. Header preservation is important, especially in minified builds.

A per-directory evidence register is maintained in `documentation/THIRD_PARTY_NOTICES_DRAFT.md`. It records observed versions/banners and explicitly marks components whose exact copied release or matching full license text is still missing. Direct template/source reference scanning found 19 library groups referenced by name. Six groups had no direct path reference: Bootstrap, Clipboard, Dropzone, Flatpickr, Highlight.js, and the now-empty fancyBox directory. This does not alone prove the first five are removable because their code may be compiled into `site.css`/application bundles or reached indirectly; removal requires bundle and runtime regression analysis.

Font Awesome Free 5.8.2 is explicitly identified. Its bundled LICENSE states that SVG/JS icons use CC BY 4.0, fonts use SIL OFL 1.1, and non-font/non-icon code uses MIT. The embedded notices must not be stripped. Brand icons remain trademarks and should only represent their respective brands.

Removed finding:

- `public/assets/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.js`
- `public/assets/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.css`

The JS header identified fancyBox 3.5.7 and a GPLv3/commercial dual license. Repository-wide usage searches found no script/style include, `data-fancybox` markup, or `.fancybox()` call. Both unused files were removed rather than assuming commercial permission.

## Webpixels Purpose commercial asset finding

The following bundled files contain an explicit banner naming **Purpose - Application UI Kit**, Webpixels, and copyright 2013-2019 Webpixels:

- `main_file/public/assets/css/purpose-blue-light.css`
- `main_file/public/assets/css/purpose-blue-dark.css`

The banner links to the official Bootstrap Themes product, whose listing describes Purpose as a paid premium UI package containing source CSS/Sass/JS, premium SVG illustrations/icons, and premium licensed plugins. The repository also contains `purpose-bkp.css`, approximately 627 icon assets below `public/assets/img/icons`, and large compiled `site.css`/`site-client.css` files consistent with that design system.

Runtime impact is material: authentication, admin, customer bill, and other layouts actively load `assets/css/site.css` or `css/site-{light,dark}.css`. The two bannered blue CSS files do not appear to be referenced directly, but removing only those copies would not remove the compiled Purpose-derived UI or resolve the underlying right-to-use question.

The official product listing shows three license tiers: Standard (single site), Multisite, and Extended (for paying users). Therefore this project cannot be represented as copyright-cleared until one of the following is supplied:

1. the original Webpixels/Bootstrap Themes license covering this ERPGo distribution and deployment model;
2. written confirmation from the ERPGo seller that the redistributed CSS, icons, illustrations, and premium plugins are sublicensable to ERPGo purchasers; or
3. replacement of the Purpose-derived CSS/icon/illustration layer with independently owned or permissively licensed assets.

This is the highest-priority third-party copyright finding in the archive. It is a license-evidence issue, not evidence by itself that the code is pirated.

## Runtime external services and CDN assets

The static URL inventory contains 1,620 URL occurrences across 170 distinct domains; many are documentation strings or package metadata rather than runtime calls. Confirmed runtime categories include payment providers, Pusher, Zoom, Telegram, Google Fonts, and third-party CDN resources.

Two avoidable CDN dependencies deserve remediation:

- `resources/views/layouts/admin.blade.php` and Messenger's head layout load NProgress 0.2.0 JavaScript/CSS from unpkg without Subresource Integrity.
- `resources/views/estimations/script.blade.php` loads the obsolete jQuery 2.1.1 build from Google CDN even though local jQuery assets exist elsewhere.

These are primarily supply-chain/privacy/availability risks rather than a copyright violation. For a controlled production build, pin and self-host reviewed copies, retain their MIT notices, and remove the redundant old jQuery include after regression testing.

## Fonts and media

Bundled font names include Poppins, Montserrat, Roboto, Font Awesome, and other webfont files. Poppins and Montserrat SVG metadata retain their upstream copyright names. Font files should be accompanied by their applicable OFL/license text in a production distribution; do not rename reserved font names in modified versions contrary to OFL terms.

PNG/JPG/GIF and landing-page demo images generally do not contain useful licensing metadata. No source-code technique can prove the photographer/illustrator granted commercial rights. Replace demo/stock images with owned or separately licensed assets unless the original ERPGo author provides a definitive asset manifest covering them.

The active landing-page bundle is a separate provenance gap. `public/landing/css/style.css` contains custom layout rules and embeds local Poppins/Montserrat font files but has no theme name, author, copyright, license, or source URL. Its Bootstrap 4.3.1 file retains an MIT banner, while the authorship/license of the custom landing design and its imagery cannot be derived from the files. Include this bundle explicitly in the seller's requested asset manifest; do not infer that Bootstrap's MIT license covers the custom CSS, fonts, or images around it.

## Nulled/backdoor scan

No first-party occurrence was found for common encoded-loader and obfuscation markers such as `gzinflate`, `gzuncompress`, `str_rot13`, ionCube loaders, or an Envato verification bypass. The previously found view-level JavaScript `eval()` was removed. `ApiController` uses `base64_decode` for a client-supplied time-tracker screenshot; that use is data decoding, not execution.

This result means “no match for the inspected indicators,” not a mathematical proof that every possible malicious behavior is absent. Runtime outbound traffic, uploaded files, database-stored scripts, and future dependencies remain separate trust surfaces.

## Priority actions

1. Verify whether paid SaaS operation is covered by an Extended License.
2. Obtain license/redistribution proof for Webpixels Purpose and its premium icons/illustrations/plugins, or replace that UI layer.
3. Obtain the original author's complete third-party asset/license manifest.
4. Replace or separately clear all demo/stock imagery before public branding.
5. Self-host reviewed NProgress assets and remove/regression-test the redundant jQuery 2.1.1 CDN include.
6. Preserve an NPM SBOM/license report from each clean release install.
7. Add a distributable `THIRD_PARTY_NOTICES` bundle containing applicable notices/license texts.
8. Preserve minified-library copyright headers and all vendor license files.
9. Have counsel review the final deployment model if customers pay for access, source is transferred, or multiple client deployments are planned.

## Authoritative references

- Envato Regular License terms: https://codecanyon.net/licenses/terms/regular
- Font Awesome Free license: https://fontawesome.com/license/free
- Webpixels Purpose product/license options: https://themes.getbootstrap.com/product/purpose-website-ui-kit/
