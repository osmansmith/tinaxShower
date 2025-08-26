export async function GET() {
  const robotsTxt = `User-agent: *
Allow: /
Disallow: /private/

Sitemap: https://tinaxshower.com/sitemap.xml`;

  return new Response(robotsTxt, {
    headers: {
      'Content-Type': 'text/plain',
    },
  });
}