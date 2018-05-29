# Files
files=Brazil.yml

# Paths
CACHE_DIR=../../cache/address
PREFIX?=source

# Programs
SCRIPT?=../../scripts/address.sh
HELP2MAN?=help2man -L en_US --no-info

.PHONY: update clean delete manpage


# General recipes
update: $(files)

clean:
	rm -r $(CACHE_DIR)

delete:
	rm $(PREFIX)/*.yml


# Manpage
manpage: address.1

address.1:
	$(HELP2MAN) ./$(SCRIPT) > address.1


# Brazil
Brazil.yml: $(CACHE_DIR)/32
	CACHE_DIR=$(CACHE_DIR) $(SCRIPT) build 32 > $(PREFIX)/Brazil.yml

$(CACHE_DIR)/32:
	mkdir -p $(CACHE_DIR)/32
	CACHE_DIR=$(CACHE_DIR) $(SCRIPT) fetch 32
