<?php
    
    namespace NeoxSeo\NeoxSeoBundle\Model;
    
    class SeoBag
    {
        public ?string       $title          = "ko";
        public ?string       $charset        = '<meta charset="UTF-8">';
        public ?array        $html           = [];
        public ?array        $link           = [];
        public ?array        $metasHttpEquiv = [];
        public ?array        $metasName      = [];
        public ?array        $metasProperty  = [];
        public ?array        $metasItemprop  = [];
        
        
        public function getTitle(): string
        {
            
            return $this->title;
        }
        
        public function setTitle(?string $title): self
        {
            $this->title =  "<title>$title</title>";
            return $this;
        }
        
        public function getCharset(): ?string
        {
            return $this->charset;
        }
        
        public function setCharset(?string $encoding): self
        {
            $this->charset = "<meta charset=$encoding/>";
            return $this;
            
        }
        
        public function getHtml(): ?array
        {
            return $this->html;
        }
        
        public function setHtml(?array $html): self
        {
            // <html lang="fr" href="https://www.gentianes.wip"/>
            foreach ($html as $key => $value) {
                $key = strtolower($key);
                $this->html[$key] = $key . "=" . "'$value'";
            }
            return $this;
        }
        
        
        public function getLink(): array
        {
            return $this->link;
        }
        
        public function setLink(?array $link): self
        {
            // <link rel="alternate" hreflang="fr" href="https://www.gentianes.wip"/>
            foreach ($link as $key => $value) {
                $key = strtolower($key);
                list($key) = explode("@", $key) ?? $key;
                $this->link[] = "<link rel='$key' $value/>";
            }
            return $this;
        }
        
        public function getMetasHttpEquiv(): array
        {
            return $this->metasHttpEquiv;
        }
        
        public function setMetasHttpEquiv(?array $httpEquiv): self
        {
            foreach ($httpEquiv as $key => $value) {
                $key = strtolower($key);
                $this->metasHttpEquiv[$key] = "<meta http-equiv='$key' content='$value'/>";
            }
            return $this;
        }
        
        public function getMetasName(): array
        {
            return $this->metasName;
        }
        
        /**
         * @param array|null $metasName
         *
         * @return $this
         */
        public function setMetasName(?array $metasName): self
        {
            foreach ($metasName as $key => $value) {
                // twitter:card & facebook  :opengraph
                $key = strtolower($key);
                $key = str_replace("-", ":", $key);
                $this->metasName[strtolower($key)] = "<meta name='$key' content='$value'/>";
            }
            return $this;
        }
        
        public function getMetasProperty(): array
        {
            return $this->metasProperty;
        }
        
        public function setMetasProperty(?array $metasProperty): self
        {
            foreach ($metasProperty as $key => $value) {
                // twitter:card & facebook  :opengraph
                $key = strtolower($key);
                $key = str_replace("-", ":", $key);
                $this->metasProperty[strtolower($key)] = "<meta property='$key' content='$value'/>";
            }
            return $this;
        }
        
        public function getMetasItemprop(): array
        {
            return $this->metasItemprop;
        }
        
        public function setMetasItemprop(?array $metasItemprop): self
        {
            foreach ($metasItemprop as $key => $value) {
                $this->metasItemprop[strtolower($key)] = "<meta itemprop='$key' content='$value'/>";
            }
            return $this;
        }
        
        public function getAllMetas(): ?array
        {
            return $this->metasHttpEquiv + $this->metasName + $this->metasProperty + $this->metasItemprop;
        }
        
    }