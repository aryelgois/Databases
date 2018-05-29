databases=address

.PHONY: all $(databases)

all: $(databases)

address:
	cd data/address && make
