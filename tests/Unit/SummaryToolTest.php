<?php

namespace DivineOmega\PHPSummary\Tests;

use DivineOmega\PHPSummary\SummaryTool;
use PHPUnit\Framework\TestCase;

class SummaryToolTest extends TestCase
{
    public function summaryDataProvider()
    {
        return [
            [
                'Cake (also known as gateau or gâteau, from French) is a form of sweet dessert that is typically baked. In its oldest forms, cakes were modifications of breads, but cakes now cover a wide range of preparations that can be simple or elaborate, and that share features with other desserts such as pastries, meringues, custards, and pies.

            Typical cake ingredients are flour, sugar, eggs, butter or oil or margarine, a liquid, and leavening agents, such as baking soda or baking powder. Common additional ingredients and flavourings include dried, candied, or fresh fruit, nuts, cocoa, and extracts such as vanilla, with numerous substitutions for the primary ingredients. Cakes can also be filled with fruit preserves,nuts or dessert sauces (like pastry cream), iced with buttercream or other icings, and decorated with marzipan, piped borders, or candied fruit.

            Cake is often served as a celebratory dish on ceremonial occasions, such as weddings, anniversaries, and birthdays. There are countless cake recipes; some are bread-like, some are rich and elaborate, and many are centuries old. Cake making is no longer a complicated procedure; while at one time considerable labor went into cake making (particularly the whisking of egg foams), baking equipment and directions have been simplified so that even the most amateur cook may bake a cake.',
            'In its oldest forms, cakes were modifications of breads, but cakes now cover a wide range of preparations that can be simple or elaborate, and that share features with other desserts such as pastries, meringues, custards, and pies. Typical cake ingredients are flour, sugar, eggs, butter or oil or margarine, a liquid, and leavening agents, such as baking soda or baking powder. Cake making is no longer a complicated procedure; while at one time considerable labor went into cake making (particularly the whisking of egg foams), baking equipment and directions have been simplified so that even the most amateur cook may bake a cake.',
            ],
            [
                '',
                '',
            ],
        ];
    }

    /**
     * @dataProvider summaryDataProvider
     */
    public function testGetSummary($content, $expected)
    {
        $summaryTool = new SummaryTool($content);

        $this->assertSame($expected, $summaryTool->getSummary());
    }

    public function summarySentencesDataProvider()
    {
        return [
            [
                'Cake (also known as gateau or gâteau, from French) is a form of sweet dessert that is typically baked. In its oldest forms, cakes were modifications of breads, but cakes now cover a wide range of preparations that can be simple or elaborate, and that share features with other desserts such as pastries, meringues, custards, and pies.

        Typical cake ingredients are flour, sugar, eggs, butter or oil or margarine, a liquid, and leavening agents, such as baking soda or baking powder. Common additional ingredients and flavourings include dried, candied, or fresh fruit, nuts, cocoa, and extracts such as vanilla, with numerous substitutions for the primary ingredients. Cakes can also be filled with fruit preserves,nuts or dessert sauces (like pastry cream), iced with buttercream or other icings, and decorated with marzipan, piped borders, or candied fruit.

        Cake is often served as a celebratory dish on ceremonial occasions, such as weddings, anniversaries, and birthdays. There are countless cake recipes; some are bread-like, some are rich and elaborate, and many are centuries old. Cake making is no longer a complicated procedure; while at one time considerable labor went into cake making (particularly the whisking of egg foams), baking equipment and directions have been simplified so that even the most amateur cook may bake a cake.',
                [
                    'In its oldest forms, cakes were modifications of breads, but cakes now cover a wide range of preparations that can be simple or elaborate, and that share features with other desserts such as pastries, meringues, custards, and pies.',
                    'Typical cake ingredients are flour, sugar, eggs, butter or oil or margarine, a liquid, and leavening agents, such as baking soda or baking powder.',
                    'Cake making is no longer a complicated procedure; while at one time considerable labor went into cake making (particularly the whisking of egg foams), baking equipment and directions have been simplified so that even the most amateur cook may bake a cake.',
                ],
            ],
            [
                '',
                [],
            ]
        ];
    }

    /**
     * @dataProvider summarySentencesDataProvider
     */
    public function testGetSummarySentences($content, $expected)
    {
        $summaryTool = new SummaryTool($content);

        $this->assertSame($expected, $summaryTool->getSummarySentences());
    }
}
