--------------------------------------------
SimpleAB v0.1.0-pl
--------------------------------------------
Author: Mark Hamstra - hello@markhamstra.com
--------------------------------------------

SimpleAB is a tool to employ A/B or multivariate testing on a MODX Revolution powered website.

It was developed by Mark Hamstra for Reply.com.

The current version lets you dynamically switch templates to one of several variations, as
defined in the custom manager page.

"Simple" in the name SimpleAB refers to the ease of setting up and managing your tests. For each
variation being displayed, there are three possible outcomes:

1. The user has seen this test before - show the same variation as before.
2. If there have been enough conversions (configurable per test), draw a random number and see
   if it is within the randomization percentage. If it is not, show the variation with the
   the highest normalized conversion rate. If it is, pick a random one.
3. Randomly pick a variation.

