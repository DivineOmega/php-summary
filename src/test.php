<?php

require_once "SummaryTool.php";
require_once "SentenceTokenizer.php";

$title = "The Top Functional Foods of 2010";

$content = "As the new year unfolds, functional foods are on target to be hotter than ever. The functional food industry got its start in the 1980s, and it’s been growing steadily since then with a projected growth rate of 56 percent from 2008 to 2011.

What do functional foods mean? According to the April 2009 position on functional foods by the American Dietetic Association (ADA), all foods are functional at some level, because they provide nutrients that furnish energy, sustain growth, or maintain and repair vital processes. While the \"functional food\" category, per se, is not officially recognized by the Food and Drug Administration, the ADA considers functional foods to be whole foods and fortified, enriched, or enhanced foods that have a potentially beneficial effect on health. Thus a list of functional foods might be as varied as nuts, calcium-fortified orange juice, energy bars, bottled teas and gluten-free foods. While many functional foods—from whole grain breads to wild salmon—provide obvious health benefits, other functional foods like acai berry or \"brain development\" foods may make overly optimistic promises. Thus, it’s important to evaluate each functional food on the basis of scientific evidence before you buy into their benefits.

What’s driving the interest in functional foods? Barbara Katz, president of HealthFocus International, a nutrition market research company based in St. Petersburg, FL, believes that consumers are more savvy regarding their health. People no longer receive all of their health advice at the doctor’s office; they now take control. And this is reflected in their shopping habits, as people purchase more foods with health benefits. \"One of the biggest trends is the increase in control shoppers want over their own health. Shoppers now want to be a part of the dialogue and are increasingly going to the Internet and to one another to seek answers to questions and gather information about health,\" adds Katz. The anti-functional food movement. Ironically, one of the hottest trends in the food scene is an emphasis on pure, clean foods—free of toxins, chemicals and additives. The pure food movement even extends into cleaner packages that feature minimal labeling and see-through covers that allow consumers to view how \"pure\" products really are. Maybe this movement is onto something, because the best functional foods on our list are those that are minimally processed, in their whole state, and naturally rich in vitamins, minerals, fiber and antioxidants.";

$summaryTool = new \DivineOmega\PHPSummary\SummaryTool($title, $content);

$summary = $summaryTool->getSummary();

echo $summary;

?>
