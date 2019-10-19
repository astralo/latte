<?php


namespace App\Services;


class CharactersNames
{
    /**
     * @param string $input
     *
     * @return array
     */
    public function parse(string $input): array
    {
        $lines = explode("\n", $input);
        $names = [];
        foreach ($lines as $line) {

            $parts = explode(';', $line);
            $parts = array_filter($parts);
            foreach ($parts as $name) {
                $names[] = trim($name);
            }
        }

        return $names;
    }
}
